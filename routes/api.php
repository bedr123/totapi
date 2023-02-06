<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PicturesController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    // Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(PicturesController::class)->group(function () {
    Route::get('pictures', 'index');
    Route::post('pictures', 'store');
    Route::get('pictures/active', 'showActive');
    Route::get('pictures/{id}', 'show');
    Route::put('pictures/{id}', 'update');
    Route::patch('pictures/{id}', 'activate');
    Route::delete('pictures/{id}', 'destroy');
}); 