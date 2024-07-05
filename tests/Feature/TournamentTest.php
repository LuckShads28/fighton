<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TournamentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_tournament(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}