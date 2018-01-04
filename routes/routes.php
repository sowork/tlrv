<?php

Route::group(['namespace' => 'Sowork\TLRV\Http\Controllers'], function (){

    Route::get('tlrv/search', 'TLRVNodeController@search');
    Route::get('tlrv/rebuild', 'TLRVNodeController@rebuild');
    Route::resource('/tlrv', 'TLRVNodeController');

    Route::resource('tlrv/addition', 'TLRVNodeAdditionController');
});
