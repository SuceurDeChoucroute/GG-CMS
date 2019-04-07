<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Games
Route::resource('games', 'GameController');
Route::get('games/{game}/players', 'GameController@players')->name('games.players');
Route::get('games/{game}/teams', 'GameController@teams')->name('games.teams');

// Players
Route::resource('players', 'PlayerController');
Route::get('players/{player}/games', 'PlayerController@games')->name('players.games');
Route::get('players/{player}/teams', 'PlayerController@teams')->name('players.teams');

// Teams
Route::resource('teams', 'TeamController');
Route::get('teams/{team}/players', 'TeamController@players')->name('teams.players');
Route::get('teams/{team}/tournaments', 'TeamController@tournaments')->name('teams.tournaments');

// Tournaments
Route::resource('tournaments', 'TournamentController');
Route::get('tournaments/{tournament}/teams', 'TournamentController@teams')->name('tournaments.teams');
