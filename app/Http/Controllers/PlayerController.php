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
        return User::where('admin', false)->get();
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
        $player->avatar = $request->avatar;
        $player->description = $request->description;
        $player->birth_date = $request->birth_date;
        $player->password = bcrypt($request->password);
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
        return $player;
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
        $player->avatar = $request->avatar;
        $player->description = $request->description;
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
}
