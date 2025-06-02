<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetitionEntryController;
use App\Http\Controllers\ClubCompetitionController;
use App\Http\Controllers\CreditTransactionController;
use App\Http\Controllers\ScoreSubmissionController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyEntriesController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ClubAdmin\DashboardController as ClubDashboardController;
use App\Http\Controllers\EarlyAccessController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/subscribe', [EarlyAccessController::class, 'store']);
Route::get('/login/google', [SocialAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::middleware(['club_admin'])->group(function () {
    // Dashboard
    Route::get('/club/dashboard', [ClubDashboardController::class, 'index'])->name('club.dashboard');

    // Profile
    Route::get('/club/profile', [ProfileController::class, 'edit'])->name('club.profile.edit');
    Route::patch('/club/profile', [ProfileController::class, 'update'])->name('club.profile.update');
    Route::delete('/club/profile', [ProfileController::class, 'destroy'])->name('club.profile.destroy');

    // Avatar
    Route::patch('/club/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('club.profile.avatar.update');

    // Competitions
    Route::get('/club/competitions', [ClubCompetitionController::class, 'index'])->name('club.competitions');
    Route::get('/club/competitions/create', [ClubCompetitionController::class, 'create'])->name('club.competitions.create');
    Route::post('/club/competitions/store', [ClubCompetitionController::class, 'store'])->name('club.competitions.store');
    Route::patch('/club/competitions/{id}/toggle', [ClubCompetitionController::class, 'toggleStatus'])->name('club.competitions.toggle');
    Route::delete('/club/competitions/{id}', [ClubCompetitionController::class, 'destroy'])->name('club.competitions.destroy');
    Route::get('/club/competitions/{id}/edit', [ClubCompetitionController::class, 'edit'])->name('club.competitions.edit');
    Route::put('/club/competitions/{competition}', [ClubCompetitionController::class, 'update'])->name('club.competitions.update');

    // Results
    Route::get('/club/results', [ClubCompetitionController::class, 'results'])->name('club.results');

});

Route::middleware(['player'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Competitions
    Route::get('/competitions', [CompetitionEntryController::class, 'index'])->name('competitions.index');
    Route::get('/results', [ClubCompetitionController::class, 'results'])->name('results.index');
    Route::get('/entries', [MyEntriesController::class, 'entries'])->name('entries.index');
    Route::post('/competitions/{id}/enter', [CompetitionEntryController::class, 'enter'])->name('competitions.enter');
    Route::delete('/competitions/{id}/unregister', [CompetitionEntryController::class, 'unregister'])->name('competitions.unregister');
    Route::get('/competitions/{id}', [ClubCompetitionController::class, 'show'])->name('competitions.show');
    Route::get('/competitions/{competition}/calendar', [ClubCompetitionController::class, 'calendar'])->name('competitions.calendar');

    // Scores
    Route::get('/scores/submit/{entry}', [ScoreSubmissionController::class, 'create'])->name('scores.submit');
    Route::get('/scores/view/{entry}', [ScoreSubmissionController::class, 'view'])->name('scores.view');
    Route::post('/scores/submit/{entry}', [ScoreSubmissionController::class, 'store'])->name('scores.store');

    // Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // Credit
    Route::get('/credit', [CreditTransactionController::class, 'index'])->name('credit.index');
});

require __DIR__.'/auth.php';
