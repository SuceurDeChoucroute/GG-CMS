<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class tournamentTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetTournaments()
    {
        $game = factory('App\Game')->create();
        $tournament = factory('App\Tournament')->create([
            'game_id' => $game->id,
        ]);

        $response = $this->get('api/tournaments');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => $tournament->name,
            'description' => $tournament->description,
            'game_id' => $game->id,
            'start_date' => $tournament->start_date,
            'end_date' => $tournament->end_date,
            'places' => $tournament->places,
            'cashprize' => $tournament->cashprize,
            'status' => $tournament->status,
            'image' => $tournament->image,
        ]);
    }

    public function testGetOneTournament()
    {
        $game = factory('App\Game')->create();
        $tournament = factory('App\Tournament')->create([
            'game_id' => $game->id,
        ]);

        $response = $this->get('api/tournaments/'.$tournament->id);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => $tournament->name,
            'description' => $tournament->description,
            'game_id' => $game->id,
            'start_date' => $tournament->start_date,
            'end_date' => $tournament->end_date,
            'places' => $tournament->places,
            'cashprize' => $tournament->cashprize,
            'status' => $tournament->status,
            'image' => $tournament->image,
        ]);
    }

    public function testCreateTournament()
    {
        Passport::actingAs(
            factory(User::class)->create(['admin' => true]),
            []
        );
        
        $game = factory('App\Game')->create();

        $response = $this->post('api/tournaments', [
            'name' => "GG-Test #8",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, officiis!",
            'game_id' => $game->id,
            'start_date' => "1999-01-01",
            'end_date' => "1999-01-02",
            'places' => 15,
            'cashprize' => 365,
            'status' => 'Closed',
            'image' => "https://testimage.com",
        ]);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('tournaments', [
            'name' => "GG-Test #8",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, officiis!",
            'game_id' => $game->id,
            'start_date' => "1999-01-01",
            'end_date' => "1999-01-02",
            'places' => 15,
            'cashprize' => 365,
            'status' => 'Closed',
            'image' => "https://testimage.com",
        ]);

        $response->assertJsonFragment([
            'name' => "GG-Test #8",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, officiis!",
            'game_id' => $game->id,
            'start_date' => "1999-01-01",
            'end_date' => "1999-01-02",
            'places' => 15,
            'cashprize' => 365,
            'status' => 'Closed',
            'image' => "https://testimage.com",
        ]);
    }

    public function testUpdateTournament()
    {
        Passport::actingAs(
            factory(User::class)->create(['admin' => true]),
            []
        );
        
        $game = factory('App\Game')->create();
        $game2 = factory('App\Game')->create();
        $tournament = factory('App\Tournament')->create([
            'game_id' => $game->id,
        ]);

        $response = $this->put('api/tournaments/'.$tournament->id, [
            'name' => "GG-Test #8",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, officiis!",
            'game_id' => $game2->id,
            'start_date' => "1999-01-01",
            'end_date' => "1999-01-02",
            'places' => 15,
            'cashprize' => 365,
            'status' => 'Closed',
            'image' => "https://testimage.com",
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('tournaments', [
            'name' => $tournament->name,
            'description' => $tournament->description,
            'game_id' => $game->id,
            'start_date' => $tournament->start_date,
            'end_date' => $tournament->end_date,
            'places' => $tournament->places,
            'cashprize' => $tournament->cashprize,
            'status' => $tournament->status,
            'image' => $tournament->image,
        ]);

        $this->assertDatabaseHas('tournaments', [
            'name' => "GG-Test #8",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, officiis!",
            'game_id' => $game2->id,
            'start_date' => "1999-01-01",
            'end_date' => "1999-01-02",
            'places' => 15,
            'cashprize' => 365,
            'status' => 'Closed',
            'image' => "https://testimage.com",
        ]);

        $response->assertJsonFragment([
            'name' => "GG-Test #8",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, officiis!",
            'game_id' => $game2->id,
            'start_date' => "1999-01-01",
            'end_date' => "1999-01-02",
            'places' => 15,
            'cashprize' => 365,
            'status' => 'Closed',
            'image' => "https://testimage.com",
        ]);
    }

    public function testDeleteTournament()
    {
        Passport::actingAs(
            factory(User::class)->create(['admin' => true]),
            []
        );
        
        $game = factory('App\Game')->create();
        $tournament = factory('App\Tournament')->create([
            'game_id' => $game->id,
        ]);

        $response = $this->delete('api/tournaments/'.$tournament->id);

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('tournaments', [
            'name' => $tournament->name,
            'description' => $tournament->description,
            'game_id' => $game->id,
            'start_date' => $tournament->start_date,
            'end_date' => $tournament->end_date,
            'places' => $tournament->places,
            'cashprize' => $tournament->cashprize,
            'status' => $tournament->status,
            'image' => $tournament->image,
        ]);

        $response->assertJsonFragment([
            'message' => 'Success',
        ]);
    }
}
