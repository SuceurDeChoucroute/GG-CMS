<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Team;

class TeamTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testGetTeams()
    {
        $team = Team::all()->first();

        $response = $this->get('api/teams');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $team->id,
            'name' => $team->name,
            'description' => $team->description,
            'avatar' => $team->avatar,
            'game_id' => $team->game_id,
        ]);
    }

    public function testCreateTeamWithoutAvatar()
    {
        $game = factory('App\Game')->create();
        $player = factory('App\User')->create();

        $response = $this->post('api/teams', [
            'name' => "Test team",
            'description' => "Lorem ipsum dolor sit amet.",
            'game_id' => $game->id,
            'captain_id' => $player->id,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('teams', [
            'name' => "Test team",
            'description' => "Lorem ipsum dolor sit amet.",
            'game_id' => $game->id,
            'avatar' => "https://api.adorable.io/avatars/285/Test team",
        ]);

        $this->assertDatabaseHas('team_user', [
            'user_id' => $player->id,
            'captain' => true,
        ]);

        $response->assertJsonFragment([
            'name' => "Test team",
            'description' => "Lorem ipsum dolor sit amet.",
            'avatar' => "https://api.adorable.io/avatars/285/Test team",
            'game_id' => $game->id,
        ]);
    }

    public function testCreateTeamWithAvatar()
    {
        $game = factory('App\Game')->create();
        $player = factory('App\User')->create();

        $response = $this->post('api/teams', [
            'name' => "Test team",
            'description' => "Lorem ipsum dolor sit amet.",
            'game_id' => $game->id,
            'avatar' => "https://image.com/test.png",
            'captain_id' => $player->id,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('teams', [
            'name' => "Test team",
            'description' => "Lorem ipsum dolor sit amet.",
            'game_id' => $game->id,
            'avatar' => "https://image.com/test.png",
        ]);

        $this->assertDatabaseHas('team_user', [
            'user_id' => $player->id,
            'captain' => true,
        ]);

        $response->assertJsonFragment([
            'name' => "Test team",
            'description' => "Lorem ipsum dolor sit amet.",
            'avatar' => "https://image.com/test.png",
            'game_id' => $game->id,
        ]);
    }

    public function testGetTeam()
    {
        $team = factory('App\Team')->create();

        $response = $this->get('api/teams/'.$team->id);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $team->id,
            'name' => $team->name,
            'description' => $team->description,
            'avatar' => $team->avatar,
            'game_id' => $team->game_id,
        ]);
    }

    public function testUpdateTeam()
    {
        $team = factory('App\Team')->create();
        $game = factory('App\Game')->create();

        $response = $this->put('api/teams/'.$team->id, [
            'name' => "Test team update",
            'description' => "Lorem ipsum dolor sit amet.",
            'avatar' => "https://image.com/test.png",
            'game_id' => $game->id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('teams', [
            'id' => $team->id,
            'name' => $team->name,
            'description' => $team->description,
            'avatar' => $team->avatar,
            'game_id' => $team->game_id,
        ]);

        $this->assertDatabaseHas('teams', [
            'name' => "Test team update",
            'description' => "Lorem ipsum dolor sit amet.",
            'avatar' => "https://image.com/test.png",
            'game_id' => $game->id,
        ]);

        $response->assertJsonFragment([
            'name' => "Test team update",
            'description' => "Lorem ipsum dolor sit amet.",
            'avatar' => "https://image.com/test.png",
            'game_id' => $game->id,
        ]);
    }

    public function testDeleteTeam()
    {
        $team = factory('App\Team')->create();

        $response = $this->delete('api/teams/'.$team->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('teams', [
            'id' => $team->id,
            'name' => $team->name,
            'description' => $team->description,
            'avatar' => $team->avatar,
            'game_id' => $team->game_id,
        ]);

        $response->assertJsonFragment([
            'message' => "Success",
        ]);
    }

    public function testTryingToFetchTeamsWithTeamWithoutPlayer()
    {
        $game = factory('App\Game')->create();
        $team = factory('App\Team')->create([
            'game_id' => $game->id,
        ]);

        $responseWithTeamWithoutPlayer = $this->get('api/teams');
        $responseWithTeamWithoutPlayer->assertStatus(200);
    }
}