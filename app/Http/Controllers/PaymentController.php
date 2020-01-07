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

        return redirect('/');
    }

    public function failedPayment()
    {
        return redirect('/');
    }

    public function isPlayerPayed(User $player)
    {
        $place = TournamentPlace::all()->where('user_id', $player->id)->first();

        if ($place) {
            return response()->json([
                'result' => true
            ]);
        }

        return response()->json([
                'result' => false
            ]);
    }
}
