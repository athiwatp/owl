<?php

namespace App\Http\Controllers\Backend;

use App\Activity;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('backend.users.index');
    }

    public function indexDatatable()
    {
        $datatable = DataTables::of(User::with('roles')->get());
        $datatable->editColumn('roles', function ($user) {
            return $user->roles->sortBy('name')->pluck('name')->implode(', ');
        });

        return $datatable;
    }

    public function createModal()
    {
        $roles = Role::all()->sortBy('name');

        return view('backend.users.create', compact('roles'));
    }

    public function create()
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'timezone' => 'required|in:'.implode(',', timezone_identifiers_list()),
            'password' => 'required|string|min:6|confirmed',
        ]);

        request()->merge(['password' => bcrypt(request()->input('password'))]);

        $user = User::create(request()->all());
        $user->syncRoles([request()->input('roles', [])]);

        activity()->by(auth()->user())->on($user)->withProperties(request()->except(['_token', 'password', 'password_confirmation']))->log('Created User');

        return response()->json([
            'flash' => ['success', 'User created!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    public function updateModal($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all()->sortBy('name');

        return view('backend.users.update', compact('user', 'roles'));
    }

    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'timezone' => 'required|in:'.implode(',', timezone_identifiers_list()),
        ]);

        $user = User::findOrFail($id);
        $user->update(request()->all());
        $user->syncRoles([request()->input('roles', [])]);

        activity()->by(auth()->user())->on($user)->withProperties(request()->except('_token'))->log('Updated User Profile');

        return response()->json([
            'flash' => ['success', 'User profile updated!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    public function delete()
    {
        $this->validate(request(), [
            'id' => 'required',
        ]);

        $user = User::findOrFail(request()->input('id'));
        $user->makeHidden(['created_at', 'updated_at', 'deleted_at']);
        $user->delete();

        activity()->by(auth()->user())->on($user)->withProperties($user)->log('Deleted User');

        return response()->json([
            'flash' => ['success', 'User deleted!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    public function passwordModal($id)
    {
        $user = User::findOrFail($id);

        return view('backend.users.password', compact('user'));
    }

    public function password($id)
    {
        $this->validate(request(), [
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update(['password' => bcrypt(request()->input('password'))]);

        activity()->by(auth()->user())->on($user)->log('Updated User Password');

        return response()->json([
            'flash' => ['success', 'User password updated!'],
            'dismiss_modal' => true,
        ]);
    }

    public function activity($id)
    {
        $user = User::findOrFail($id);

        return view('backend.users.activity', compact('user'));
    }

    public function activityDatatable($id)
    {
        return DataTables::of(Activity::where('causer_id', $id)->get());
    }

    public function activityDataModal($id)
    {
        $activity = Activity::findOrFail($id);
        $compact = [];
        $compact['activity'] = $activity;

        if ($activity->subject_type) {
            $subject_class = $activity->subject_type;
            $subject = $subject_class::find($activity->subject_id);
            $compact['subject'] = $subject;
        }

        if ($activity->causer_type) {
            $causer_class = $activity->causer_type;
            $causer = $causer_class::find($activity->causer_id);
            $compact['causer'] = $causer;
        }

        return view('backend.users.activity-data', $compact);
    }
}