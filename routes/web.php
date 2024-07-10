<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentMatchController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
Route::get('/leaderboard', [HomeController::class, 'leaderboard'])->name('leaderboard');

// Tournament
Route::resource('tournament', TournamentController::class);
Route::get('/tournament/{slug}/select-team', [TournamentController::class, 'select_team'])->name('select_team')->middleware('auth');
Route::post('/tournament/{slug}/select-team', [TournamentController::class, 'join'])->name('join_tournament')->middleware('auth');
Route::get('/tournament/{slug}/bracket', [TournamentController::class, 'bracket'])->name('bracket')->middleware('auth');

// User
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::resource('profile', ProfileController::class)->only(['index', 'update', 'edit', 'show']);
Route::get('/dashboard/{nickname}', [ProfileController::class, 'dashboard'])->middleware('auth')->name('user_dashboard');

// Team
Route::resource('team', TeamController::class);
Route::get('/team/{team}/edit/anggota', [TeamController::class, 'anggota'])->name('edit_anggota')->middleware('auth');
Route::get('/team/{team}/edit/cadangan', [TeamController::class, 'cadangan'])->name('edit_cadangan')->middleware('auth');
Route::get('/team/{team}/edit/logs', [TeamController::class, 'logs'])->name('team_logs')->middleware('auth');
Route::post('/team/{team}/edit/cadangan/ubah_slot', [TeamController::class, 'changeSlot'])->name('change_slot')->middleware('auth');
Route::get('/team/{team}/request/{userSlug}', [TeamController::class, 'request'])->name('request_join_team')->middleware('auth');
Route::post('/team/{team}/response', [TeamController::class, 'requestResponse'])->name('member_action')->middleware('auth');

// Organizer
Route::resource('organizer', OrganizerController::class);
Route::get('/organizer/{slug}/dashboard', [OrganizerController::class, 'dashboard'])->name('organizer_dashboard')->middleware('auth');
Route::get('/organizer/{slug}/dashboard/tournaments', [OrganizerController::class, 'tournaments'])->name('organizer_tournaments')->middleware('auth');

// Tournament Match
Route::resource('matches', TournamentMatchController::class, ['except' => ['create']]);
Route::get('/tournament/{slug}/match/create', [TournamentMatchController::class, 'create'])->name('matches.create')->middleware('auth');
Route::get('/tournament/{slug}/match/score/{id}/{team1}/{team2}', [TournamentMatchController::class, 'score'])->name('match.score')->middleware('auth');
Route::put('/tournament/{slug}/match/score/{id}', [TournamentMatchController::class, 'update_score'])->name('match.update_score')->middleware('auth');
Route::delete('/tournament/{slug}/match/{id}/delete', [TournamentMatchController::class, 'destroy'])->name('match.destroy')->middleware('auth');
Route::get('/tournament/{slug}/match/nextRound', [TournamentMatchController::class, 'generateNextRound'])->middleware('auth')->name('match.generateNextRound');
Route::get('/tournament/{slug}/match/winner', [TournamentMatchController::class, 'generateWinner'])->middleware('auth')->name('match.generateWinner');

// Bracket
Route::get('/bracket/get/{id}', [TournamentMatchController::class, 'getTeamData']);
Route::post('/bracket/post/{id}', [TournamentController::class, 'postData'])->name('generate_round');

// Admin
Route::resource('admin', AdminController::class)->middleware('auth');
Route::get('/admin/dashboard/getUser/', [AdminController::class, 'getUser']);
