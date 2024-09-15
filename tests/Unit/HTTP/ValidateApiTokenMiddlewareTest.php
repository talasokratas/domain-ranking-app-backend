<?php

namespace Tests\Feature;

use Tests\TestCase;

class ValidateApiTokenMiddlewareTest extends TestCase
{
    /** @test */
    public function assertValidToken()
    {
        $response = $this->withHeaders([
            'Authorization' => env('APP_API_KEY'),
        ])->get('/api/domains');

        $response->assertStatus(200);
    }

    /** @test */
    public function assertInvalidToken()
    {
        $response = $this->withHeaders([
            'Authorization' => 'invalid-token',
        ])->get('/api/domains');

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthorized']);
    }

    /** @test */
    public function assertMissingToken()
    {
        $response = $this->get('/api/domains');

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthorized']);
    }
}
