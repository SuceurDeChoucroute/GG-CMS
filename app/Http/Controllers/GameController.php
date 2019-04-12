<?php

namespace App\Http\Controllers;

use App\Game;
use App\Rank;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Game::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $game = new Game;
        $game->name = $request->name;
        $game->description = $request->description;
        $game->image = $request->image;
        $game->places = $request->places;
        $game->save();

        return $game;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return $game;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $game->name = $request->name;
        $game->description = $request->description;
        $game->image = $request->image;
        $game->places = $request->places;
        $game->save();

        return $game;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        if ($game->delete()) {
            return response()->json([
                'message' => 'Success',
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Error',
            ], 500);
        }
    }

    public function players(Game $game)
    {
        return $game->players;
    }

    public function teams(Game $game)
    {
        return $game->teams;
    }

    public function ranks(Game $game) {
        return $game->ranks;
    }

    public function addRank(Request $request, Game $game)
    {
        $rank = Rank::create([
            'name' => $request->name,
            'image' => $request->image,
            'game_id' => $game->id,
        ]);

        return $rank;
    }

    public function deleteRank(Request $request, Game $game, Rank $rank)
    {
        $rank->delete();

        return response()->json([
            'message' => 'Success',
        ]);
    }
}
