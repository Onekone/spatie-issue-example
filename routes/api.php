<?php

use Illuminate\Http\Request;
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

Route::group(['middleware' => 'auth:api', 'prefix' => 'tokens'], function () {
    Route::any('test-success', function () {
        return 'This must succeed within API guard with API permission';
    })->middleware('can:nonweb');
    Route::any('test-fail', function () {
        return 'This must NOT succeed within API guard with API permission';
    })->middleware('can:nonapi');
});

Route::post('/tokens/create', function (Request $request) {

    if ($user = \App\Models\User::whereEmail($request->email)->first()) {
        $token = $user->createToken($user->name . '_' . date('YmdHis'));

        return ['token' => $token->plainTextToken];
    } else {
        abort(401);
    }

});
