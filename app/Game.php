<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name', 'description', 'places', 'image',
    ];

    public function players()
    {
        return $this->belongsToMany('App\User');
    }

    public function teams()
    {
        return $this->hasMany('App\Team');
    }
}
