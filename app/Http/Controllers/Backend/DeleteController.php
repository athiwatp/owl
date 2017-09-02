<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function modal($route, $id)
    {
        return view('backend.delete', compact('route' ,'id'));
    }
}