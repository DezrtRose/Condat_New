<?php

Route::group(array('module' => 'User', 'middleware' => ['auth'], 'namespace' => 'App\Modules\User\Controllers'), function() {
    Route::resource('user', 'UserController');
    Route::get('users/data', 'UserController@getData');
    Route::get('profile', 'UserController@edit');
    Route::post('profile', 'UserController@update');
    Route::get('users/{user_id}/status', ['as' => 'user.changeStatus', 'uses' => 'UserController@changeStatus']);
});