<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlayerTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetPlayers()
    {
        $player = factory('App\User')->create();

        $response = $this->get('api/players');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $player->id,
            'name' => $player->name,
            'pseudo' => $player->pseudo,
        ]);
    }

    public function testGetOnePlayer()
    {
        $player = factory('App\User')->create();

        $response = $this->get('api/players/'.$player->id);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $player->id,
            'name' => $player->name,
            'pseudo' => $player->pseudo,
            'description' => $player->description,
            'email' => $player->email,
            'avatar' => $player->avatar,
        ]);
    }

    public function testCreatePlayer()
    {
        $response = $this->post('api/players', [
            'name' => 'Test',
            'birth_date' => '1999-01-01',
            'email' => 'test@example.com',
            'pseudo' => 'test_pseudo',
            'description' => 'Lorem ipsum dolor sit amet.',
            'avatar' => 'test.com',
        ]);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('users', [
            'name' => 'Test',
            'birth_date' => '1999-01-01',
            'email' => 'test@example.com',
            'pseudo' => 'test_pseudo',
            'description' => 'Lorem ipsum dolor sit amet.',
            'avatar' => 'test.com',
        ]);

        $response->assertJsonFragment([
            'name' => 'Test',
            'birth_date' => '1999-01-01',
            'email' => 'test@example.com',
            'pseudo' => 'test_pseudo',
            'description' => 'Lorem ipsum dolor sit amet.',
            'avatar' => 'test.com',
        ]);
    }

    public function testUpdatePlayer()
    {
        $player = factory('App\User')->create();

        $response = $this->put('api/players/'.$player->id, [
            'name' => 'Test',
            'pseudo' => 'test_pseudo',
            'description' => 'Lorem ipsum dolor sit amet.',
            'avatar' => 'test.com',
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('users', [
            'name' => $player->name,
            'pseudo' => $player->pseudo,
            'description' => $player->description,
            'avatar' => $player->avatar,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test',
            'pseudo' => 'test_pseudo',
            'description' => 'Lorem ipsum dolor sit amet.',
            'avatar' => 'test.com',
        ]);

        $response->assertJsonFragment([
            'name' => 'Test',
            'pseudo' => 'test_pseudo',
            'description' => 'Lorem ipsum dolor sit amet.',
            'avatar' => 'test.com',
        ]);
    }

    public function testDeletePlayer()
    {
        $player = factory('App\User')->create();

        $response = $this->delete('api/players/'.$player->id);

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('users', [
            'name' => $player->name,
            'pseudo' => $player->pseudo,
            'description' => $player->description,
            'avatar' => $player->avatar,
        ]);

        $response->assertJsonFragment([
            'message' => 'Success',
        ]);
    }
}
