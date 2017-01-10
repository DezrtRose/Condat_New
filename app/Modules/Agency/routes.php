<?php

Route::group(array('module' => 'Agency', 'middleware' => ['auth'], 'namespace' => 'App\Modules\Agency\Controllers'), function() {
    Route::resource('agency', 'AgencyController');
    Route::get('agencies/{id}/deactivate', ['as' => 'agencies.deactivate', 'uses' => 'AgencyController@deactivate']);
    Route::get('agencies/{id}/activate', ['as' => 'agencies.activate', 'uses' => 'AgencyController@activate']);
    Route::get('agencies/data', 'AgencyController@getData');
    Route::get('domain/suggestion/{name}', 'AgencyController@getDomainSuggestion');
    Route::get('subscription/{id}/renew', ['as' => 'agency.renew', 'uses' => 'AgencyController@subscriptionRenew']);
    Route::post('subscription/{id}/renew', 'AgencyController@postSubscriptionRenew');
    Route::post('agency/get_subscription_amount', 'AgencyController@get_subscription_amount');
    Route::get('agencies/complete_subscription_paypal', 'AgencyController@complete_subscription_paypal');
});