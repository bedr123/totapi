<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PicturesController;
use App\Http\Controllers\StatisticsController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    // Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('google-login/{token}', 'googleLogin');
    Route::post('facebook-login/{token}', 'facebookLogin');
    Route::get('me', 'me');
    Route::get('users', 'getUsers');
});

Route::controller(PicturesController::class)->group(function () {
    Route::get('pictures', 'index');
    Route::post('pictures', 'store');
    Route::get('pictures/active', 'showActive');
    Route::get('pictures/{id}', 'show');
    Route::put('pictures/{id}', 'update');
    Route::patch('pictures/{id}', 'activate');
    Route::delete('pictures/{id}', 'destroy');
    Route::get('archive', 'archive');
}); 

Route::controller(StatisticsController::class)->group(function () {
    Route::put('statistics/update', 'updateStatistics');
    Route::get('statistics/monthly/reset', 'resetMonthlyStatistics');
    Route::get('leaderboard', 'getLeaderboard');
    Route::get('leader', 'getLeader');
}); 