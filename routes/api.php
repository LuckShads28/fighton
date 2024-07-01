<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->get('/users', [APIController::class, 'getUsers']);
Route::get('/user', [APIController::class, 'getUser']);
// Route::post('/addUser', [APIController::class, 'addUser']);

Route::get('/tournaments', [APIController::class, 'getTournaments']);
Route::post('/tournament/create', [APIController::class, 'createTournament']);
Route::post('/tournament/join', [APIController::class, 'joinTournament']);
Route::get('/tournament/registered_team', [APIController::class, 'getRegisteredTeam']);
Route::get('/tournament/history', [APIController::class, 'getTournamentHistory']);

Route::get('/teams', [APIController::class, 'getTeams']);
Route::post('/team/create', [APIController::class, 'createTeam']);
Route::post('/team/join', [APIController::class, 'joinTeam']);
Route::get('/team/member', [APIController::class, 'getMember']);

Route::get('/organizers', [APIController::class, 'getOrganizers']);
Route::post('/organizer/create', [APIController::class, 'createOrganizer']);

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);
