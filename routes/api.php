<?php

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

Route::post('/user/login', 'LoginController');

Route::middleware('auth:sanctum')
    ->group(function () {
        // actions
        Route::post('/meditations', 'MeditationController@store');
        Route::patch('/{meditation}/complete', 'MeditationController@complete');
        // statistics
        Route::get('/meditations/statistics/summary', 'Meditation\StatisticsController@summary');
        Route::get(
            '/meditations/statistics/active-days-in-this-month',
            'Meditation\StatisticsController@activeDaysInThisMonth'
        );
        Route::get(
            '/meditations/statistics/last-7-days',
            'Meditation\StatisticsController@lastSevenDays'
        );
    });
