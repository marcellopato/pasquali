<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    //only auth users can
    Route::get('/sites', [App\Http\Controllers\SiteController::class, 'getSites'])->name('get.sites');
    Route::get('/site', [App\Http\Controllers\SiteController::class, 'index'])->name('new.site');
});
