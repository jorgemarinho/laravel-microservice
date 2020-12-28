<?php

use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {

    $exceptionCreateEditAction = [
        'except' => ['create', 'edit']
    ];

    Route::resource('categories', 'CategoryController', $exceptionCreateEditAction);
    Route::resource('genres', 'GenreController', $exceptionCreateEditAction);
    Route::resource('cast_members', 'CastMemberController', $exceptionCreateEditAction);
    Route::resource('videos', 'VideoController', $exceptionCreateEditAction);

});