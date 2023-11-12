<?php

namespace Tests\Feature\Api\v1;

use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Tests\AppTestCase;

class AuthTest extends AppTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call(command: 'migrate:fresh'); // Resetando a base de dados
    }

    /**
     * Verifica um retorno com sucesso
     *
     * @test
     */
    public function check_login_return_with_success(): void
    {
        $data = ['name' => fake()->name(),'email' => fake()->email(),'password' => fake()->password(),];
        $user = User::create($data);

        $response = $this->post(uri: '/api/v1/login', data: ['email' => $data['email'], 'password' => $data['password'],]);
        $response->assertStatus(status: 200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'token' => [
                    'accessToken' => [
                        'name',
                        'abilities',
                        'expires_at',
                        'tokenable_id',
                        'tokenable_type',
                        'updated_at',
                        'created_at',
                        'id',
                    ],
                    'plainTextToken',
                ],
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'phone_personal',
                    'phone_professional',
                    'url_photo',
                    'status',
                    'general_settings',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by',
                    'updated_values',
                    'deleted_at',
                    'deleted_by',
                ],
            ],
            'metadata'
        ]);

        unset($data['password']);
        $response->assertJsonPath(path: "success", expect: true);
        $response->assertJsonPath(path: "data.user.id", expect: $user->id);
        foreach ($data as $key => $val) {
            $response->assertJsonPath(path: "data.user.$key", expect: $val);
        }
    }

    /**
     * Verifica um retorno com erro
     *
     * @test
     */
    public function check_login_with_return_error(): void
    {
        $data = ['name' => fake()->name(),'email' => fake()->email(),'password' => fake()->password(),];
        User::create($data);

        $response = $this->post(uri: '/api/v1/login', data: ['email' => $data['email'], 'password' => 'senha-errada',]);
        $response->assertStatus(status: 400);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
    }

    /**
     * Verifica um retorno com erro
     *
     * @test
     */
    public function check_logout_return_success(): void
    {
        $response = $this->token()->post(uri: '/api/v1/logout');
        $response->assertStatus(status: 200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
    }
}
