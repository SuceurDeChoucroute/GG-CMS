<?php

namespace App\Http\Controllers;

use App\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournaments = [];

        foreach (Tournament::all() as $key => $tournament) {
            array_push($tournaments, [
                'tournament' => $tournament,
                'game' => $tournament->game,
            ]);
        }

        return $tournaments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tournament = new Tournament;
        $tournament->name = $request->name;
        $tournament->description = $request->description;
        $tournament->game_id = $request->game_id;
        $tournament->start_date = $request->start_date;
        $tournament->end_date = $request->end_date;
        $tournament->places = $request->places;
        $tournament->cashprize = $request->cashprize;
        $tournament->status = $request->status;
        $tournament->image = $request->image;
        $tournament->save();

        return $tournament;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function show(Tournament $tournament)
    {
        return [
            'tournament' => $tournament,
            'tournamentGame' => $tournament->game,
            'players' => $tournament->players,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tournament $tournament)
    {
        $tournament->name = $request->name;
        $tournament->description = $request->description;
        $tournament->game_id = $request->game_id;
        $tournament->start_date = $request->start_date;
        $tournament->end_date = $request->end_date;
        $tournament->places = $request->places;
        $tournament->cashprize = $request->cashprize;
        $tournament->status = $request->status;
        $tournament->image = $request->image;
        $tournament->save();

        return [
            'tournament' => $tournament,
            'tournamentGame' => $tournament->game,
            'players' => $tournament->players,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();

        return response()->json([
            'message' => 'Success',
        ]);
    }

    public function teams(Tournament $tournament)
    {
        return $tournament->teams;
    }

    public function teamsPercentage()
    {
        $tournaments = Tournament::all()->where('status', 'Open');

        $labels = [];
        $values = [];

        foreach ($tournaments as $tournament) {
            array_push($labels, $tournament->name);
            array_push($values, (count($tournament->teams) / $tournament->places) * 100);
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
