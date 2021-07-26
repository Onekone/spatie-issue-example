<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'tokens', 'middleware' => 'auth'], function () {
    Route::any('test-success', function () {
        return 'This must succeed within WEB guard with WEB permission';
    })->middleware('can:nonapi');
    Route::any('test-fail', function () {
        return 'This must NOT succeed within WEB guard with WEB permission';
    })->middleware('can:nonweb');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
