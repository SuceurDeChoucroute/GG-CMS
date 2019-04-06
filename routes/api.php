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

// Players
Route::resource('players', 'PlayerController');
Route::get('players/{player}/games', 'PlayerController@games')->name('players.games');

// Teams
Route::resource('teams', 'TeamController');
