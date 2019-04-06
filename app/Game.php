<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name', 'description', 'image',
    ];

    public function players()
    {
        return $this->belongsToMany('App\User');
    }
}
