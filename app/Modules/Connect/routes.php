<?php

Route::group(array('module' => 'Connect', 'namespace' => 'App\Modules\Connect\Controllers'), function() {

    Route::resource('connect', 'ConnectController');
    Route::post('connect/index', 'ConnectController@sendEmail');
    
});	