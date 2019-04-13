<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = [];

        foreach (Team::all() as $key => $team) {
            array_push($teams, [
                'team' => $team,
                'players' => count($team->players),
                'game' => $team->game,
                'captain' => $team->captain[0],
            ]);
        }
        return $teams;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team = new Team;
        $team->name = $request->name;
        $team->description = $request->description;
        $team->game_id = $request->game_id;
        if (!$request->avatar) {
            $team->avatar = "https://api.adorable.io/avatars/285/".$request->name;
        }
        else {
            $team->avatar = $request->avatar;
        }
        $team->save();

        $team->players()->attach($request->captain_id, ['captain' => true]);

        return $team;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return [
            'team' => $team,
            'players' => $team->players,
            'game' => $team->game,
            'participations' => $team->tournaments
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $team->name = $request->name;
        $team->description = $request->description;
        $team->avatar = $request->avatar;
        $team->game_id = $request->game_id;
        $team->save();

        return $team;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json([
            'message' => 'Success',
        ], 200);
    }

    public function players(Team $team)
    {
        return $team->players;
    }

    public function tournaments(Team $team)
    {
        return $team->tournaments;
    }
}
