<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoterAuthController;
use App\Http\Controllers\VotingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// ---------------------------
// Landing Page
// ---------------------------
Route::get('/', function () {
    return view('welcome');
});

// ---------------------------
// Voter Authentication Routes
// ---------------------------
Route::get('/voter/login', [VoterAuthController::class, 'showLoginForm'])->name('voter.login');
Route::post('/voter/login', [VoterAuthController::class, 'login'])->name('voter.login.submit');
Route::post('/voter/logout', [VoterAuthController::class, 'logout'])->name('voter.logout');

// ---------------------------
// Protected Voting Routes (auth:voter)
// ---------------------------
Route::middleware(['auth:voter'])->group(function () {
    Route::get('/vote', [VotingController::class, 'index'])->name('voting.index');
    Route::post('/vote', [VotingController::class, 'submit'])->name('voting.submit');
    Route::get('/thank-you', [VotingController::class, 'thankyou'])->name('voting.thankyou');
});
