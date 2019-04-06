<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'description', 'avatar', 'game_id',
    ];

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function players()
    {
        return $this->belongsToMany('App\User')->withPivot('captain');
    }
}
