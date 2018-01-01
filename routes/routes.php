<?php

Route::group(['namespace' => 'Sowork\TLRV\Http\Controllers'], function (){

    Route::get('tlrv/search', 'TLRVNodeController@search');
    Route::resource('/tlrv', 'TLRVNodeController');

    Route::resource('tlrv/addition', 'TLRVNodeAdditionController');
});
