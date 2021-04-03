<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentCashprizeStep extends Model
{
    protected $fillable = [
        'tournament_id', 'places', 'cashprize', 'achieved'
    ];

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }
}
