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

Route::group(['middleware' => ['json.response']], function () {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/register', 'AuthController@register')->name('register');

    Route::middleware('auth:api')->group(function() {

    });
    
    // Games
    Route::resource('games', 'GameController');
    Route::get('games/{game}/players', 'GameController@players')->name('games.players');
    Route::get('games/{game}/teams', 'GameController@teams')->name('games.teams');
    
    // Ranks
    Route::get('games/{game}/ranks', 'GameController@ranks')->name('games.ranks');
    Route::get('games/{game}/ranks/{rank}', 'GameController@showRank')->name('games.ranks.show');
    Route::post('games/{game}/ranks', 'GameController@addRank')->name('games.ranks.store');
    Route::put('games/{game}/ranks/{rank}', 'GameController@updateRank')->name('games.ranks.update');
    Route::delete('games/{game}/ranks/{rank}', 'GameController@deleteRank')->name('games.ranks.store');
    
    // Players
    Route::get('players/admins', 'PlayerController@admins')->name('players.admins');
    Route::resource('players', 'PlayerController');
    Route::get('players/{player}/games', 'PlayerController@games')->name('players.games');
    Route::get('players/{player}/teams', 'PlayerController@teams')->name('players.teams');
    Route::post('players/{player}/grantAdmin', 'PlayerController@grantAdmin')->name('players.admins.grant');
    Route::post('players/{player}/revokeAdmin', 'PlayerController@revokeAdmin')->name('players.admins.revoke');
    
    // Teams
    Route::resource('teams', 'TeamController');
    Route::get('teams/{team}/players', 'TeamController@players')->name('teams.players');
    Route::get('teams/{team}/tournaments', 'TeamController@tournaments')->name('teams.tournaments');
    
    // Tournaments
    Route::resource('tournaments', 'TournamentController');
    Route::get('tournaments/{tournament}/teams', 'TournamentController@teams')->name('tournaments.teams');
    
    // Posts
    Route::resource('posts', 'PostController');
    
    // Rules
    Route::get('rules', 'RuleController@show');
    Route::put('rules', 'RuleController@update');
});

