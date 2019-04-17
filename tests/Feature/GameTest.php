<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GameTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetGames()
    {
        $game = factory('App\Game')->create();

        $response = $this->get('api/games');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $game->id,
            'name' => $game->name,
        ]);
    }

    public function testGetOneGame()
    {
        $game = factory('App\Game')->create();

        $response = $this->get('api/games/'.$game->id);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $game->id,
            'description' => $game->description,
            'places' => $game->places,
            'image' => $game->image,
            'name' => $game->name,
        ]);
    }

    public function testCreateGame()
    {
        $response = $this->post('api/games', [
            'name' => 'Test',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, aliquid!',
            'places' => 5,
            'image' => 'test.com',
        ]);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('games', [
            'name' => 'Test',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, aliquid!',
            'places' => 5,
            'image' => 'test.com',
        ]);

        $response->assertJsonFragment([
            'name' => 'Test',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, aliquid!',
            'places' => 5,
            'image' => 'test.com',
        ]);
    }

    public function testUpdateGame()
    {
        $game = factory('App\Game')->create();

        $response = $this->put('api/games/'.$game->id, [
            'name' => 'Test',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, aliquid!',
            'places' => 5,
            'image' => 'test.com',
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('games', [
            'name' => $game->name,
            'description' => $game->description,
            'places' => $game->places,
            'image' => $game->image,
        ]);

        $this->assertDatabaseHas('games', [
            'name' => 'Test',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, aliquid!',
            'places' => 5,
            'image' => 'test.com',
        ]);

        $response->assertJsonFragment([
            'name' => 'Test',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, aliquid!',
            'places' => 5,
            'image' => 'test.com',
        ]);
    }

    public function testDeleteGame()
    {
        $game = factory('App\Game')->create();

        $response = $this->delete('api/games/'.$game->id);

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('games', [
            'name' => $game->name,
            'description' => $game->description,
            'places' => $game->places,
            'image' => $game->image,
        ]);

        $response->assertJsonFragment([
            'message' => 'Success',
        ]);
    }
}
