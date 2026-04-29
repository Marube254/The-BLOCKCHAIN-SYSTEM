<?php

use App\Http\Controllers\API\VoteController;

Route::get('/test', function () {
    return response()->json(['status' => 'API working']);
});

Route::post('/register', [VoteController::class, 'register']);
Route::post('/login', [VoteController::class, 'login']);
Route::post('/forgot-password', [VoteController::class, 'forgotPassword']);
Route::post('/reset-password', [VoteController::class, 'resetPassword']);
Route::get('/candidates', [VoteController::class, 'getCandidates']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/vote', [VoteController::class, 'castVote']);
    Route::get('/user', [VoteController::class, 'getUser']);
    Route::post('/logout', [VoteController::class, 'logout']);
});