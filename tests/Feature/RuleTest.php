<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Rule;

class RuleTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetRules()
    {
        $counter = count(Rule::all());
        $response = $this->get('/api/rules');

        if ($counter == 1) {
            $response->assertStatus(200);
        }
        else {
            $response->assertStatus(201);
        }
    }

    public function testUpdateRules()
    {
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
