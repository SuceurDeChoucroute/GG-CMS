<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'name', 'description', 'game_id', 'start_date', 'end_date', 'places', 'cashprize', 'status', 'image', 'stripe_key',
    ];
    
    public function teams()
    {
        return $this->belongsToMany('App\Team')->withPivot('place');
    }

    public function players()
    {
        return $this->belongsToMany('App\User')->withPivot('place');
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }
}
