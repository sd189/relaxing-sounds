<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('isAuthenticated')->group(function () {
    // categories
    Route::group(['prefix' => 'categories'], function () {
        Route::get('', 'CategoryController@getCategories');
        Route::get('/{slug}', 'CategoryController@getCategory')
            ->where('slug', '[A-Za-z-0-9-]+');
    });

   // songs
    Route::group(['prefix' => 'songs'], function () {
        Route::get('', 'SongController@getSongs');
    });
});

Route::post('users/auth', 'UserController@authenticateWebAdmin');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
