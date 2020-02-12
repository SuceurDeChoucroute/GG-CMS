<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Tournament;
use Carbon\Carbon;
use App\Team;
use App\User;


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
            $registered = [];
            $type = '';

            if ($tournament->game->places != 1) {
                $type = 'team';
                $registered = $tournament->teams;
            }
            else {
                $type = 'player';
                $registered = $tournament->players;
            }

            array_push($tournaments, [
                'tournament' => $tournament,
                'registered' => [
                    'type' => $type,
                    $registered
                ],
                'game' => $tournament->game,
            ]);
        }

        return $tournaments;
    }

    public function index_site()
    {
        $tournaments = [];

        foreach (Tournament::all()->where('status', 'Open') as $key => $tournament) {
            $registered = [];
            $type = '';
            
            if ($tournament->game->places != 1) {
                $type = 'team';
                $registered = $tournament->teams;
            }
            else {
                $type = 'player';
                $registered = $tournament->players;
            }

            array_push($tournaments, [
                'tournament' => $tournament,
                'registeredType' => $type,
                'registered' => $registered,
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
        $tournament->stripe_key = $request->stripe_key;
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

    public function players(Tournament $tournament)
    {
        return $tournament->players;
    }

    public function teamsPercentage()
    {
        $tournaments = Tournament::all()->where('status', 'Open');

        $labels = [];
        $values = [];

        foreach ($tournaments as $tournament) {
            if ($tournament->game->places > 1) {
                array_push($labels, $tournament->name);
                array_push($values, (count($tournament->teams) / $tournament->places) * 100);
            }
            else {
                array_push($labels, $tournament->name);
                array_push($values, (count($tournament->players) / $tournament->places) * 100);
            }
        }

        return ['labels' => $labels, 'values' => $values];
    }

    public function tournamentsDaysLeft()
    {
        $tournaments = Tournament::all()->where('status', 'Open');
        $today = Carbon::now();

        $labels = [];
        $values = [];

        foreach ($tournaments as $tournament) {
            $tournamentDate = new Carbon($tournament->start_date);
            array_push($labels, $tournament->name);
            array_push($values, $today->diffInDays($tournamentDate));
        }

        return ['labels' => $labels, 'values' => $values];
    }

    public function tournamentsAverageFilling()
    {
        $tournaments = Tournament::all()->where('status', 'Open');
        $countFilling = 0;

        foreach ($tournaments as $tournament) {
            if ($tournament->game->places > 1) {
                $countFilling += (count($tournament->teams) / $tournament->places) * 100;
            }
            else {
                $countFilling += (count($tournament->players) / $tournament->places) * 100;
            }
        }

        return $countFilling / count($tournaments);
    }

    public function getPayedPlayers()
    {
        $players = DB::table('tournament_places')
                     ->join('users', 'users.id', '=', 'tournament_places.user_id')
                     ->join('tournaments', 'tournaments.id', '=', 'tournament_places.tournament_id')
                     ->select('tournaments.name as tournament_name', 'users.pseudo as user_pseudo')
                     ->get();

        return $players;
    }

    public function registerTeam(Tournament $tournament, Team $team)
    {
        $tournament->teams()->attach($team);
        
        return response()->json([
            'message' => 'Success',
        ]);
    }

    public function unregisterTeam(Tournament $tournament, Team $team)
    {
        $tournament->teams()->detach($team);
        
        return response()->json([
            'message' => 'Success',
        ]);
    }

    public function registerPlayer(Tournament $tournament, User $player)
    {
        $tournament->players()->attach($player);
        
        return response()->json([
            'message' => 'Success',
        ]);
    }

    public function unregisterPlayer(Tournament $tournament, User $player)
    {
        $tournament->players()->detach($player);

        return response()->json([
            'message' => 'Success',
        ]);
    }
}
