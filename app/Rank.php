<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = [
        'name', 'image', 'game_id',
    ];

    public function game()
    {
        return $this->belongsTo('App\Game');
    }
}
