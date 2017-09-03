<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\crud_model_class;
use Yajra\DataTables\Facades\DataTables;

class crud_model_classController extends Controller
{
    public function index()
    {
        return view('backend.crud_model_variables.index');
    }

    public function indexDatatable()
    {
        return DataTables::of(crud_model_class::query());
    }

    public function createModal()
    {
        return view('backend.crud_model_variables.create');
    }

    public function create()
    {
        $this->validate(request(), [
            /* crud_rule_create */
        ]);

        $crud_model_variable = crud_model_class::create(request()->all());

        activity()->by(auth()->user())->on($crud_model_variable)->withProperties(request()->except('_token'))->log('Created crud_model_string');

        return response()->json([
            'flash' => ['success', 'crud_model_string created!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    public function updateModal($id)
    {
        $crud_model_variable = crud_model_class::findOrFail($id);

        return view('backend.crud_model_variables.update', compact('crud_model_variable'));
    }

    public function update($id)
    {
        $this->validate(request(), [
            /* crud_rule_update */
        ]);

        $crud_model_variable = crud_model_class::findOrFail($id);
        $crud_model_variable->update(request()->all());

        activity()->by(auth()->user())->on($crud_model_variable)->withProperties(request()->except('_token'))->log('Updated crud_model_string');

        return response()->json([
            'flash' => ['success', 'crud_model_string updated!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    public function delete()
    {
        $this->validate(request(), [
            'id' => 'required',
        ]);

        $crud_model_variable = crud_model_class::findOrFail(request()->input('id'));
        $crud_model_variable->makeHidden(['created_at', 'updated_at', 'deleted_at']);
        $crud_model_variable->delete();

        activity()->by(auth()->user())->on($crud_model_variable)->withProperties($crud_model_variable)->log('Deleted crud_model_string');

        return response()->json([
            'flash' => ['success', 'crud_model_string deleted!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }
}