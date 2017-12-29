<?php

Route::group(['prefix' => 'tlrv', 'namespace' => 'Sowork\TLRV\HTTP\Controllers'], function (){

    Route::get('/search', 'TLRVNodeController@search');
    Route::resource('/', 'TLRVNodeController');
});
