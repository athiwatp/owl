<?php

return [

    'title' => [
        'schema' => 'string("crud_attribute_name")->unique()',
        'input' => 'text',
        'rule_create' => 'required|unique:crud_model_variables',
        'rule_update' => 'required|unique:crud_model_variables,crud_attribute_name,$id',
        'datatable' => true,
    ],

    'make' => [
        'schema' => 'string("crud_attribute_name")',
        'input' => 'text',
        'rule_create' => 'required',
        'rule_update' => 'required',
        'datatable' => true,
    ],

    'model' => [
        'schema' => 'string("crud_attribute_name")',
        'input' => 'text',
        'rule_create' => 'required',
        'rule_update' => 'required',
        'datatable' => true,
    ],

    'year' => [
        'schema' => 'integer("crud_attribute_name")',
        'input' => 'number',
        'rule_create' => 'required|numeric',
        'rule_update' => 'required|numeric',
        'datatable' => true,
    ],

    'description' => [
        'schema' => 'text("crud_attribute_name")->nullable()',
        'input' => 'textarea',
    ],

];