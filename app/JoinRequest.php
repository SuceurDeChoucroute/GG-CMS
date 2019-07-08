<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    protected $fillable = [
        'team_id', 'user_id', 'response'
    ];

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function player()
    {
        return $this->belongsTo('App\User');
    }
}
