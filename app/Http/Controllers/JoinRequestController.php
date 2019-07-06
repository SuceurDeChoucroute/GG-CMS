<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\JoinRequest;
use Illuminate\Http\Request;
use App\Notifications\AcceptJoinRequest;
use App\Notifications\JoinRequest as JoinRequestNotification;

class JoinRequestController extends Controller
{
    /**
     * Undocumented variable
     *
     * @var Team
     */
    private $team;
    
    /**
     * Undocumented variable
     *
     * @var User
     */
    private $player;

    public function __construct(Team $team, User $player)
    {
        $this->team = $team;
        $this->player = $player;
    }

    public function sendJoinRequest()
    {
        $check = false;
        $playerRequests = $this->player->joinrequests;

        foreach ($playerRequests as $request) {
            if ($request->team_id == $this->team->id) {
                $check = true;
                break;
            }
        }

        if (!$check) {
            JoinRequest::create([
                'team_id' => $this->team->id,
                'user_id' => $this->player->id,
            ]);
    
            $this->team->captain[0]->notify(new JoinRequestNotification($this->team));
            return true;
        }

        return false;
    }

    public function acceptJoinRequest()
    {
        $joinrequest = JoinRequest::where('team_id', $this->team->id)->where('user_id', $this->player->id)->first();
        $joinrequest->response = true;
        $joinrequest->save();

        $this->player->notify(new AcceptJoinRequest($this->team));

        return true;
    }

    public function refuseJoinRequest()
    {
        $joinrequest = JoinRequest::where('team_id', $this->team->id)->where('user_id', $this->player->id)->first();
        $joinrequest->response = false;
        $joinrequest->save();

        $this->player->notify(new AcceptJoinRequest($this->team));

        return true;
    }
}
