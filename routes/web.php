<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoterAuthController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\VoterController;


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
// Voting Routes (Kiosk Flow, no auth)
// ---------------------------

// Step 1: Start voting (voter ID input)
Route::get('/vote/start', [VotingController::class, 'start'])->name('voting.start');

// Step 2: Check voter existence
Route::post('/vote/check', [VotingController::class, 'check'])->name('voting.check');

// Step 3: Show registration form for new voters
Route::get('/vote/register', [VotingController::class, 'showRegisterForm'])->name('voting.register');
Route::post('/vote/register', [VotingController::class, 'register']);

// Step 4: Voting page (select candidates)
Route::get('/vote/page', [VotingController::class, 'votePage'])->name('voting.page');

// Step 5: Submit vote with fingerprint verification
Route::post('/vote/submit', [VotingController::class, 'submitVote'])->name('voting.submit');

// Step 6: Thank you page after successful vote
Route::get('/vote/thankyou', [VotingController::class, 'thankyou'])->name('voting.thankyou');

// ---------------------------
// Voter Authentication Routes (New System)
// ---------------------------
Route::prefix('voter')->name('voter.')->group(function () {
    // Public routes
    Route::middleware('guest:voter')->group(function () {
        Route::get('auth', [VoterAuthController::class, 'showAuthForm'])->name('auth');
        Route::post('auth/register', [VoterAuthController::class, 'register'])->name('register');
        Route::post('auth/login', [VoterAuthController::class, 'login'])->name('login');
        Route::post('auth/send-reset-link', [VoterAuthController::class, 'sendResetLink'])->name('send-reset-link');
        Route::get('auth/reset-password/{token}', [VoterAuthController::class, 'showResetForm'])->name('show-reset-form');
        Route::post('auth/reset-password', [VoterAuthController::class, 'resetPassword'])->name('reset-password');
    });

    // Protected routes (requires voter authentication)
    Route::middleware('auth:voter')->group(function () {
        Route::get('voting-page', [VoterAuthController::class, 'showVotingPage'])->name('voting');
        Route::post('submit-vote', [VoterAuthController::class, 'submitVote'])->name('submit-vote');
        Route::post('logout', [VoterAuthController::class, 'logout'])->name('logout');
    });
});



Route::get('/voters/search', [VotingController::class, 'search']);
Route::post('/voters/register', [VotingController::class, 'register']);



Route::get('/voting/start', [VotingController::class, 'start'])->name('voting.start');
Route::post('/voting/check', [VotingController::class, 'check'])->name('voting.check');

Route::get('/voting/register', [VotingController::class, 'showRegisterForm'])->name('voting.register');
Route::post('/voting/register', [VotingController::class, 'register'])->name('voting.register.submit');

Route::get('/voting/page', [VotingController::class, 'votePage'])->name('voting.page');
Route::post('/voting/submit', [VotingController::class, 'submitVote'])->name('voting.submit');

Route::get('/voting/thankyou', [VotingController::class, 'thankyou'])->name('voting.thankyou');

// AJAX: search voters
Route::get('/voters/search', [VotingController::class, 'ajaxSearch'])->name('voters.search');

// AJAX: register new voter
Route::post('/voters/register', [VotingController::class, 'ajaxRegister'])->name('voters.register');




Route::get('/voters/search', [VotingController::class, 'ajaxSearch']);
Route::post('/voters/register', [VotingController::class, 'ajaxRegister']);
Route::post('/voting/submit', [VotingController::class, 'submitVote']);
Route::get('/voting/thankyou', [VotingController::class, 'thankyou']);

// --------------------------
// Protected Voting Routes (auth:voter)
// ---------------------------
Route::middleware(['auth:voter'])->group(function () {
    Route::get('/vote', [VotingController::class, 'index'])->name('voting.index');
    Route::post('/vote', [VotingController::class, 'submit'])->name('voting.submit');
    Route::get('/thank-you', [VotingController::class, 'thankyou'])->name('voting.thankyou');

});
