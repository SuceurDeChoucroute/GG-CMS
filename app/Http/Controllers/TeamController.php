<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\JoinRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\JoinRequestController;
use App\Notifications\JoinRequest as JoinRequestNotification;

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
            $captain = [];

            try {
                $captain = $team->captain[0];
            } catch (\Throwable $th) {
                $captain = null;
            }

            array_push($teams, [
                'team' => $team,
                'players' => count($team->players),
                'game' => $team->game,
                'captain' => $captain,
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
        $playersRequest = array();
        $joinrequests = array();

        foreach ($team->joinrequests as $joinrequest) {
            if ($joinrequest->response === null) {
                array_push($joinrequests, $joinrequest);
            }
        }

        foreach ($joinrequests as $joinrequest) {
            array_push($playersRequest, User::find($joinrequest->user_id));
        }

        return [
            'team' => $team,
            'players' => $team->players,
            'game' => $team->game,
            'participations' => $team->tournaments,
            'joinrequests' => [
                'joinrequests' => $joinrequests,
                'players' => $playersRequest
            ]
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

    public function joinRequest(Team $team, User $player)
    {
        $joinrequest = new JoinRequestController($team, $player);
        $validation = $joinrequest->sendJoinRequest();

        if ($validation) {
            return response()->json([
                'message' => 'Request successfully sended !',
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Request already sended ...',
            ], 401);
        }
    }

    public function responseJoinRequest(Team $team, User $player, $response)
    {
        $joinrequest = new JoinRequestController($team, $player);
        $validation = null;

        switch ($response) {
            case 'accept':
                $validation = $joinrequest->acceptJoinRequest();
                $team->players()->attach($player);
                break;
                
            case 'refuse':
                $validation = $joinrequest->refuseJoinRequest();
                break;
                
            default:
                # code...
                break;
        }

        if ($validation) {
            return response()->json([
                'message' => 'Response successfully sended !',
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Response already sended ...',
            ], 401);
        }       
    }

    public function tournaments(Team $team)
    {
        return $team->tournaments;
    }

    public function teamPercentage() {
        $teams = Team::all();

        $countTeams = count($teams);
        $full = 0;
        $incomplete = 0;

        foreach ($teams as $team) {
            if (count($team->players) == $team->game->places) {
                $full++;
            }
            else {
                $incomplete++;
            }
        }
        
        $full = ($full / $countTeams) * 100;
        $incomplete = ($incomplete / $countTeams) * 100;

        return [$full, $incomplete];
    }
}
