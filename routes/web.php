<?php

// home/index
Route::get('/', 'IndexController@index')->name('index');

// contact
Route::group(['middleware' => 'allow:contact'], function () {
    Route::get('contact', 'ContactController@sendForm')->name('contact');
    Route::post('contact', 'ContactController@send');
});

Route::group(['middleware' => 'guest'], function () {
    // auth
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::group(['middleware' => 'allow:registration'], function () {
        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'Auth\RegisterController@register');
    });
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(['middleware' => 'auth'], function () {
    // auth
    Route::get('profile', 'Auth\ProfileController@updateForm')->name('profile');
    Route::post('profile', 'Auth\ProfileController@update');
    Route::get('password', 'Auth\PasswordController@updateForm')->name('password');
    Route::post('password', 'Auth\PasswordController@update');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    // dashboard
    Route::get('dashboard', 'Backend\DashboardController@index')->name('dashboard');

    // delete confirmation modal
    Route::get('delete/{route}/{id}', 'Backend\DeleteController@modal')->name('delete');

    // settings
    Route::group(['middleware' => 'permission:Update Settings'], function () {
        Route::get('settings', 'Backend\SettingController@updateForm')->name('settings');
        Route::post('settings', 'Backend\SettingController@update');
    });

    // roles
    Route::group(['middleware' => 'permission:View Roles'], function () {
        Route::get('roles', 'Backend\RoleController@index')->name('roles');
        Route::get('roles/datatable', 'Backend\RoleController@indexDatatable')->name('roles.datatable');
    });
    Route::group(['middleware' => 'permission:Create Roles'], function () {
        Route::get('roles/create', 'Backend\RoleController@createModal')->name('roles.create');
        Route::post('roles/create', 'Backend\RoleController@create');
    });
    Route::group(['middleware' => ['permission:Update Roles', 'notadminrole']], function () {
        Route::get('roles/update/{id}', 'Backend\RoleController@updateModal')->name('roles.update');
        Route::post('roles/update/{id}', 'Backend\RoleController@update');
    });
    Route::post('roles/delete', 'Backend\RoleController@delete')->name('roles.delete')->middleware(['permission:Delete Roles', 'notadminrole']);

    // users
    Route::group(['middleware' => 'permission:View Users'], function () {
        Route::get('users', 'Backend\UserController@index')->name('users');
        Route::get('users/datatable', 'Backend\UserController@indexDatatable')->name('users.datatable');
    });
    Route::group(['middleware' => 'permission:Create Users'], function () {
        Route::get('users/create', 'Backend\UserController@createModal')->name('users.create');
        Route::post('users/create', 'Backend\UserController@create');
    });
    Route::group(['middleware' => 'permission:View Activity'], function () {
        Route::get('users/activity/{id}', 'Backend\UserController@activity')->name('users.activity');
        Route::get('users/activity/datatable/{id}', 'Backend\UserController@activityDatatable')->name('users.activity.datatable');
        Route::get('users/activity/data/{id}', 'Backend\UserController@activityDataModal')->name('users.activity.data');
    });
    Route::group(['middleware' => 'permission:Update Users'], function () {
        Route::get('users/update/{id}', 'Backend\UserController@updateModal')->name('users.update');
        Route::post('users/update/{id}', 'Backend\UserController@update');
        Route::get('users/password/{id}', 'Backend\UserController@passwordModal')->name('users.password');
        Route::post('users/password/{id}', 'Backend\UserController@password');
    });
    Route::post('users/delete', 'Backend\UserController@delete')->name('users.delete')->middleware('permission:Delete Users');

    /* crud_routes */
});