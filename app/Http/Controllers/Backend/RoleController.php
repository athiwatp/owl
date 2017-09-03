<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('backend.roles.index');
    }

    public function indexDatatable()
    {
        return DataTables::of(Role::query());
    }

    public function createModal()
    {
        $group_permissions = Permission::orderBy('group', 'asc')->orderBy('id', 'asc')->get()->groupBy('group');

        return view('backend.roles.create', compact('group_permissions'));
    }

    public function create()
    {
        $this->validate(request(), [
            'name' => 'required|unique:roles',
        ]);

        $role = Role::create(request()->only('name'));
        $role->syncPermissions(request()->input('permissions', []));

        activity()->by(auth()->user())->on($role)->withProperties(request()->except('_token'))->log('Created Role');

        return response()->json([
            'flash' => ['success', 'Role created!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    public function updateModal($id)
    {
        $role = Role::findOrFail($id);
        $group_permissions = Permission::orderBy('group', 'asc')->orderBy('id', 'asc')->get()->groupBy('group');

        return view('backend.roles.update', compact('role', 'group_permissions'));
    }

    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'required|unique:roles,name,'.$id,
        ]);

        $role = Role::findOrFail($id);
        $role->update(request()->only('name'));
        $role->syncPermissions(request()->input('permissions', []));

        activity()->by(auth()->user())->on($role)->withProperties(request()->except('_token'))->log('Updated Role');

        return response()->json([
            'flash' => ['success', 'Role updated!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    public function delete()
    {
        $this->validate(request(), [
            'id' => 'required',
        ]);

        $role = Role::findOrFail(request()->input('id'));
        $role->makeHidden(['created_at', 'updated_at', 'deleted_at']);
        $role->delete();

        activity()->by(auth()->user())->on($role)->withProperties($role)->log('Deleted Role');

        return response()->json([
            'flash' => ['success', 'Role deleted!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }
}