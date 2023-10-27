<?php

namespace Tests\Feature\Api\v1\Users;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiUserTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_users_list_all(): void
    {
        $response = $this->get(uri: '/api/v1/users');
        $response->assertStatus(status: 200);
    }
}
