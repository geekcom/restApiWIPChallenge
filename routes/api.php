<?php

Route::group(['prefix' => 'v1/products'], function () {
    Route::post('/', 'ProductController@store');
    Route::get('/', 'ProductController@all')->name('products');
    Route::get('{product_id}', 'ProductController@show');
    Route::put('{product_id}', 'ProductController@update');
    Route::delete('{product_id}', 'ProductController@delete');
});

Route::group(['prefix' => 'v1/carts'], function () {
    Route::post('/', 'CartController@store');
    Route::get('/', 'CartController@all')->name('carts');
    Route::get('{cart_id}', 'CartController@show');
    Route::put('{cart_id}', 'CartController@update');
    Route::delete('{cart_id}', 'CartController@delete');
    Route::get('purchases/{cart_id}', 'CartController@purchasesByCart');
});

Route::group(['prefix' => 'v1/purchases'], function () {
    Route::post('/', 'PurchaseController@store');
    Route::get('/', 'PurchaseController@all')->name('purchases');
    Route::get('{cart_id}', 'PurchaseController@show');
    Route::put('{cart_id}', 'PurchaseController@update');
    Route::delete('{cart_id}', 'PurchaseController@delete');
});