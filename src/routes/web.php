<?php

use Illuminate\Support\Facades\Route;
use drlear\FleetTracking\Controllers\FleetController;
use drlear\FleetTracking\Controllers\FleetParticipantController;

Route::group([
    'namespace' => 'drlear\FleetTracking\Controllers',
    'middleware' => ['web', 'auth'],
    'prefix' => 'fleettracking',
], function () {
    Route::resource('fleet', FleetController::class);
    Route::post('fleet/{fleet}/join', [FleetParticipantController::class, 'join'])->name('fleet.join');
    Route::post('fleet/{fleet}/leave', [FleetParticipantController::class, 'leave'])->name('fleet.leave');
});
