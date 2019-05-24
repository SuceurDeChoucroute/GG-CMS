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
    // Public routes
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/register', 'AuthController@register')->name('register');

    // Private routes
    Route::middleware('auth:api')->group(function() {
        Route::get('/user', 'AuthController@user');
        Route::get('/logout', 'AuthController@logout')->name('logout');
    });
    
    // Games
    Route::resource('games', 'GameController');
    Route::get('games/{game}/players', 'GameController@players')->name('games.players');// Private
    Route::get('games/{game}/teams', 'GameController@teams')->name('games.teams');// Private
    
    // Ranks
    Route::get('games/{game}/ranks', 'GameController@ranks')->name('games.ranks');// Private
    Route::get('games/{game}/ranks/{rank}', 'GameController@showRank')->name('games.ranks.show');// Private
    Route::post('games/{game}/ranks', 'GameController@addRank')->name('games.ranks.store');// Private
    Route::put('games/{game}/ranks/{rank}', 'GameController@updateRank')->name('games.ranks.update');// Private
    Route::delete('games/{game}/ranks/{rank}', 'GameController@deleteRank')->name('games.ranks.store');// Private
    
    // Players
    Route::get('players/admins', 'PlayerController@admins')->name('players.admins');// Private
    Route::resource('players', 'PlayerController');
    Route::get('players/{player}/games', 'PlayerController@games')->name('players.games');
    Route::get('players/{player}/teams', 'PlayerController@teams')->name('players.teams');
    Route::post('players/{player}/grantAdmin', 'PlayerController@grantAdmin')->name('players.admins.grant');// Private
    Route::post('players/{player}/revokeAdmin', 'PlayerController@revokeAdmin')->name('players.admins.revoke');// Private
    
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
    Route::put('rules', 'RuleController@update');// Private
});

