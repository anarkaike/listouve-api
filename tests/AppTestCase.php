<?php

namespace Tests;

use App\Models\User;

class AppTestCase extends TestCase
{
    protected function getToken() {
        $data = ['name' => fake()->name(),'email' => fake()->email(),'password' => fake()->password(),];
        User::create($data);

        $response = $this->post(uri: '/api/v1/login', data: ['email' => $data['email'], 'password' => $data['password'],]);

        return json_decode($response->getContent())->data->token->plainTextToken;
    }

    protected function token() {
        return $this->withToken($this->getToken());
    }
}
