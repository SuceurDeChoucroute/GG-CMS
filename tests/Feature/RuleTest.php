<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Rule;

class RuleTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetRules()
    {
        $response = $this->get('/api/rules');
        
        $response->assertStatus(200);
    }

    public function testUpdateRules()
    {
        Passport::actingAs(
            factory(User::class)->create(['admin' => true]),
            []
        );

        $counter = count(Rule::all());

        if ($counter == 0) {
            factory('App\Rule')->create();
        }

        $response = $this->put('/api/rules', [
            'content' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nesciunt, pariatur?'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('rules', [
            'content' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nesciunt, pariatur?'
        ]);

        $response->assertJsonFragment([
            'content' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nesciunt, pariatur?'
        ]);
    }
}
