<?php

use App\Http\Controllers\API\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});

Route::post('/register', [VoteController::class, 'register']);
Route::post('/login', [VoteController::class, 'login']);
Route::post('/forgot-password', [VoteController::class, 'forgotPassword']);
Route::post('/reset-password', [VoteController::class, 'resetPassword']);
Route::get('/candidates', [VoteController::class, 'getCandidates']);
Route::get('/sectors', [VoteController::class, 'getSectors']);
Route::get('/results', [VoteController::class, 'getResults']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [VoteController::class, 'getUser']);
    Route::post('/vote', [VoteController::class, 'castVote']);
    Route::get('/my-vote', [VoteController::class, 'getMyVote']);
    Route::get('/verify-vote/{hash}', [VoteController::class, 'verifyVote']);
    Route::post('/logout', [VoteController::class, 'logout']);
    Route::post('/enroll-fingerprint', [VoteController::class, 'enrollFingerprint']);
    Route::get('/voter-fingerprint', [VoteController::class, 'getVoterFingerprint']);
});