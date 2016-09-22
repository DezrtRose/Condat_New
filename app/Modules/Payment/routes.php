<?php

Route::group(array('module' => 'Payment', 'middleware' => ['auth'], 'namespace' => 'App\Modules\Payment\Controllers'), function() {

    Route::resource('payment', 'PaymentController');
    Route::get('payments/data', 'PaymentController@getData');

});	