<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    public function index_site()
    {
        return User::where('visibility', 1)->orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $player = new User;
        $player->name = $request->name;
        $player->email = $request->email;
        $player->pseudo = $request->pseudo;
        $player->description = $request->description;
        $player->birth_date = $request->birth_date;
        $player->password = bcrypt($request->password);
        $player->secret_key = Str::random(40);

        if (!$request->avatar) {
            $player->avatar = "https://cdn.discordapp.com/attachments/192623917163216897/1013895853452300359/unknown.png";
        }
        else {
            $player->avatar = $request->avatar;
        }
        
        $player->save();

        return $player;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $player)
    {
        $teamGames = [];
        foreach ($player->teams as $key => $team) {
            array_push($teamGames, $team->game);
        }

        return [
            'player' => $player,
            'teams' => $player->teams,
            'games' => $player->games,
            'teamGames' => $teamGames,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $player)
    {
        $player->name = $request->name;
        $player->pseudo = $request->pseudo;
        $player->description = $request->description;
        if (!$request->avatar) {
            $player->avatar = "https://cdn.discordapp.com/attachments/192623917163216897/1013895853452300359/unknown.png";
        }
        else {
            $player->avatar = $request->avatar;
        }
        $player->save();

        return $player;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $player)
    {
        // Delete each team where the player was the captain
        foreach ($player->teams as $team) {
            if ($team->captain = $player) {
                $team->delete();
            }
        }
        
        // Delete the player
        $player->delete();
        return response()->json([
            'message' => 'Success',
        ], 200);
    }

    public function addGame(User $player, Request $request)
    {
        $player->games()->attach($request->game_id);

        return $player;
    }

    public function deleteGame(User $player, Request $request)
    {
        $player->games()->detach($request->game_id);

        return $player;
    }

    public function games(User $player)
    {
        return $player->games;
    }

    public function teams(User $player)
    {
        $results = [];

        foreach ($player->teams as $key => $team) {
            array_push($results, [
                'team' => $team,
                'players_count' => count($team->players),
            ]);
        }

        return $results;
    }

    public function admins()
    {
        $admins = [];
        foreach (User::all() as $key => $player) {
            if ($player->admin) {
                array_push($admins, $player);
            }
        }

        return $admins;
    }

    public function grantAdmin(User $player)
    {
        $player->admin = true;
        $player->save();

        return response()->json([
            'message' => 'Player granted to admin !'
        ]);
    }

    public function revokeAdmin(User $player)
    {
        $admins = User::all()->where('admin', 1);

        if (count($admins) > 1) {
            $player->admin = false;
            $player->save();
    
            return response()->json([
                'title' => 'Admin revoked !',
                'message' => "Admin successfully revoked"
            ]);
        }

        return response()->json([
                'title' => "Admin not revoked",
                'message' => "You can't revoke the only admin"
            ]);
    }

    public function changeVisibility(User $player)
    {
        $player->visibility = !$player->visibility;
        $player->save();

        return response()->json([
            'message' => 'Player visibility changed'
        ]);
    }

    public function getPlayerJoinRequests(User $player)
    {
        return $player->joinrequests;
    }

    public function regenerateSecretKeys()
    {
        $players = User::all();

        foreach ($players as $player) {
            $player->secret_key = Str::random(40);
            $player->save();
        }

        return response()->json([
            'message' => "All the secret keys has been regenerate successfully !"
        ]);
    }

    public function countNewPlayersThisMonth()
    {
        $count = DB::table('users')
            ->whereMonth('created_at', date('n'))
            ->count();

        return $count;
    }
}
