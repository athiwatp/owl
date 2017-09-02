
    // crud_model_variables
    Route::group(['middleware' => 'permission:View crud_model_strings'], function () {
        Route::get('crud_model_variables', 'Backend\crud_model_classController@index')->name('crud_model_variables');
        Route::get('crud_model_variables/datatable', 'Backend\crud_model_classController@indexDatatable')->name('crud_model_variables.datatable');
    });
    Route::group(['middleware' => 'permission:Create crud_model_strings'], function () {
        Route::get('crud_model_variables/create', 'Backend\crud_model_classController@createModal')->name('crud_model_variables.create');
        Route::post('crud_model_variables/create', 'Backend\crud_model_classController@create');
    });
    Route::group(['middleware' => 'permission:Update crud_model_strings'], function () {
        Route::get('crud_model_variables/update/{id}', 'Backend\crud_model_classController@updateModal')->name('crud_model_variables.update');
        Route::post('crud_model_variables/update/{id}', 'Backend\crud_model_classController@update');
    });
    Route::post('crud_model_variables/delete', 'Backend\crud_model_classController@delete')->name('crud_model_variables.delete')->middleware('permission:Delete crud_model_strings');