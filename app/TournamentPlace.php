<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentPlace extends Model
{
    protected $fillable = [
        'tournament_id', 'user_id',
    ];
    
    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }

    public function player()
    {
        return $this->belongsTo('App\User');
    }
}
