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

    public function captain()
    {
        return $this->players()->where('captain', true);
    }

    public function tournaments()
    {
        return $this->belongsToMany('App\Tournament')->withPivot('place');
    }

    public function joinrequests()
    {
        return $this->hasMany('App\JoinRequest');
    }
}
