<?php

namespace App\Http\Controllers;

use App\User;
use App\Tournament;
use App\TournamentPlace;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function successfulPayment($secretKey, Tournament $tournament)
    {
        $player = User::all()->where('secret_key', $secretKey)->first();

        if ($player) {
            $place = new TournamentPlace;
            $place->user_id = $player->id;
            $place->tournament_id = $tournament->id;
            $place->save();
        }

        return view('site');
    }

    public function failedPayment()
    {
        return view('site');
    }

    public function isPlayerPayed($player)
    {
        $place = TournamentPlace::all()->where('user_id', $player->id)->first();

        if ($place) {
            return true;
        }

        return false;
    }
}
