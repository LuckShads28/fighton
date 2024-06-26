<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentMatchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Tournament
Route::resource('tournament', TournamentController::class);
Route::get('/tournament/{slug}/select-team', [TournamentController::class, 'select_team'])->name('select_team')->middleware('auth');
Route::post('/tournament/{slug}/select-team', [TournamentController::class, 'join'])->name('join_tournament')->middleware('auth');

// User
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('profile', ProfileController::class)->only(['index', 'update', 'edit', 'show']);

// Team
Route::resource('team', TeamController::class);
Route::get('/team/{team}/edit/anggota', [TeamController::class, 'anggota'])->name('edit_anggota')->middleware('auth');
Route::get('/team/{team}/edit/cadangan', [TeamController::class, 'cadangan'])->name('edit_cadangan')->middleware('auth');
Route::get('/team/{team}/request/{userSlug}', [TeamController::class, 'request'])->name('request_join_team')->middleware('auth');
Route::post('/team/{team}/response', [TeamController::class, 'requestResponse'])->name('member_action')->middleware('auth');

// Organizer
Route::resource('organizer', OrganizerController::class);
Route::get('/organizer/{slug}/dashboard', [OrganizerController::class, 'dashboard'])->name('organizer_dashboard')->middleware('auth');
Route::get('/organizer/{slug}/dashboard/tournaments', [OrganizerController::class, 'tournaments'])->name('organizer_tournaments')->middleware('auth');

// Tournament Match
Route::resource('matches', TournamentMatchController::class, ['except' => ['create']]);
Route::get('/tournament/{slug}/match/create', [TournamentMatchController::class, 'create'])->name('matches.create')->middleware('auth');
Route::get('/tournament/{slug}/match/score/{id}', [TournamentMatchController::class, 'score'])->name('match.score')->middleware('auth');
Route::put('/tournament/{slug}/match/score/{id}', [TournamentMatchController::class, 'update_score'])->name('match.update_score')->middleware('auth');
