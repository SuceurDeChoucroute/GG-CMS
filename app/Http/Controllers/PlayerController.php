<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
        if (!$request->avatar) {
            $player->avatar = "https://api.adorable.io/avatars/285/".$request->email;
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
            $player->avatar = "https://api.adorable.io/avatars/285/".$request->email;
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
        $player->delete();
        return response()->json([
            'message' => 'Success',
        ], 200);
    }

    public function games(User $player)
    {
        return $player->games;
    }

    public function teams(User $player)
    {
        return $player->teams;
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
        $player->admin = false;
        $player->save();

        return response()->json([
            'message' => 'Admin revoked !'
        ]);
    }
}
