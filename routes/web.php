<?php

Route::group(['prefix' => 'library'], function () {
    Route::get('', 'CategoryController@viewAll')->name('categories');
    Route::get('/{slug}', 'CategoryController@view')
        ->where('slug', '[A-Za-z-0-9-]+')
        ->name('category');
});

Route::any('{any}', function () {
    return redirect(route('categories'));
})->where('any', '.*');
