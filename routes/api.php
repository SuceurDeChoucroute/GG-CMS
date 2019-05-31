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
    /*
    |--------------------------------------------------------------------------
    | PRIVATE Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:api')->group(function() {
        // Auth
        Route::get('/user', 'AuthController@user')->name('users.show');
        Route::get('/logout', 'AuthController@logout')->name('logout');
        
        // Games
        Route::resource('games', 'GameController')->only(['store', 'update', 'destroy']);
        
        // Ranks
        Route::post('games/{game}/ranks', 'GameController@addRank')->name('games.ranks.store');
        Route::put('games/{game}/ranks/{rank}', 'GameController@updateRank')->name('games.ranks.update');
        Route::delete('games/{game}/ranks/{rank}', 'GameController@deleteRank')->name('games.ranks.store');
        
        // Players
        Route::resource('players', 'PlayerController')->only(['store', 'update', 'destroy']);
        Route::get('players/admins', 'PlayerController@admins')->name('players.admins');
        Route::post('players/{player}/grantAdmin', 'PlayerController@grantAdmin')->name('players.admins.grant');
        Route::post('players/{player}/revokeAdmin', 'PlayerController@revokeAdmin')->name('players.admins.revoke');
        Route::post('players/{player}/visibility', 'PlayerController@changeVisibility')->name('players.admins.visibility'); 
        
        // Teams
        Route::resource('teams', 'TeamController')->only(['store', 'update', 'destroy']);
        
        // Tournaments
        Route::resource('tournaments', 'TournamentController')->only(['store', 'update', 'destroy']);
        
        // Posts
        Route::resource('posts', 'PostController')->only(['store', 'update', 'destroy']);
        
        // Rules
        Route::put('rules', 'RuleController@update')->name('rules.update');
    });
    
    /*
    |--------------------------------------------------------------------------
    | PUBLIC Routes
    |--------------------------------------------------------------------------
    */
    // Auth
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/register', 'AuthController@register')->name('register');

    // Games
    Route::resource('games', 'GameController')->only(['index', 'show']);
    Route::get('games/{game}/players', 'GameController@players')->name('games.players');
    Route::get('games/{game}/teams', 'GameController@teams')->name('games.teams');
    
    // Ranks
    Route::get('games/{game}/ranks', 'GameController@ranks')->name('games.ranks');
    Route::get('games/{game}/ranks/{rank}', 'GameController@showRank')->name('games.ranks.show');
    
    // Players
    Route::resource('players', 'PlayerController')->only(['index', 'show']);
    Route::get('players/{player}/games', 'PlayerController@games')->name('players.games');
    Route::get('players/{player}/teams', 'PlayerController@teams')->name('players.teams');
    
    // Teams
    Route::resource('teams', 'TeamController')->only(['index', 'show']);
    Route::get('teams/{team}/players', 'TeamController@players')->name('teams.players');
    Route::get('teams/{team}/tournaments', 'TeamController@tournaments')->name('teams.tournaments');
    
    // Tournaments
    Route::resource('tournaments', 'TournamentController')->only(['index', 'show']);
    Route::get('tournaments/{tournament}/teams', 'TournamentController@teams')->name('tournaments.teams');
    
    // Posts
    Route::resource('posts', 'PostController')->only(['index', 'show']);
    
    // Rules
    Route::get('rules', 'RuleController@show')->name('rules.index');
});
