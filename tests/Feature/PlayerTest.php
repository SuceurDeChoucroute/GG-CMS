<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
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

    /**
     * @group ignore
     */
    public function testCreatePlayer()
    {
        Passport::actingAs(
            factory(User::class)->create(['admin' => true]),
            []
        );

        $response = $this->post('api/players', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'pseudo' => 'test_pseudo',
            'avatar' => 'test.com',
            'birth_date' => '1999-01-01',
            'description' => 'Lorem ipsum dolor sit amet.',
        ]);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('users', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'pseudo' => 'test_pseudo',
            'avatar' => 'test.com',
            'birth_date' => '1999-01-01',
            'description' => 'Lorem ipsum dolor sit amet.',
        ]);

        $response->assertJsonFragment([
            'name' => 'Test',
            'email' => 'test@example.com',
            'pseudo' => 'test_pseudo',
            'description' => 'Lorem ipsum dolor sit amet.',
            'birth_date' => '1999-01-01',
            'avatar' => 'test.com',
        ]);
    }

    public function testUpdatePlayer()
    {
        Passport::actingAs(
            factory(User::class)->create(['admin' => true]),
            []
        );

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
        Passport::actingAs(
            factory(User::class)->create(['admin' => true]),
            []
        );

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
