<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait Validate
{
    // validate request and allow/disallow in demo mode
    public function validate(Request $request, $rules, $allow_demo = false)
    {
        if (config('owl.demo') && !$allow_demo) {
            throw new HttpResponseException(response()->json(['flash' => ['danger', 'Featured disabled in demo mode.']]));
        }
        else {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }
    }
}