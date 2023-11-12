<?php

namespace Tests\Feature\Api\v1;

use Tests\AppTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Enums\User\UserStatusEnum;
use App\Models\User;

/**
 * Testa os end points do recurso usuários(users)
 */
class UsersTest extends AppTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->post(uri: '/api/v1/logout');
        Artisan::call(command: 'migrate:fresh'); // Resetando a base de dados
        $this->flushHeaders();
    }

    /**
     * Verifica um retorno com sucesso para o end point listAll
     *
     * @test
     */
    public function check_list_all_return_with_success(): void
    {
        $users = User::factory(count: 5)->create();
        $response = $this->token()->get(uri: '/api/v1/users');
        $response->assertStatus(status: 200);
        $response->assertJsonCount(count: 6, key: 'data'); // Um usuário é criado dentro de $this->token()
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [$this->user(onlyKeys: true)],
            'metadata'
        ]);

        $keys = $this->user(onlyKeys: true);
        foreach ($users as $k => $user) {
            foreach ($keys as $key) {
                $response->assertJsonPath(path: "data.$k.$key", expect: $user->$key);
            }
        }
    }

    /**
     * Verifica um retorno com sucesso para o end point findById
     *
     * @test
     */
    public function check_find_by_id_return_with_success(): void
    {
        $user = User::factory()->create();
        $response = $this->token()->get(uri: '/api/v1/users/' . $user->id);
        $response->assertStatus(status: 200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->user(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->user(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $user->$key);
        }
    }

    /**
     * Verifica um retorno com sucesso para o end point create
     *
     * @test
     */
    public function check_create_return_with_success(): void
    {
        $data = $this->user();
        $data['password'] = fake()->password();

        $response = $this->token()->post(uri: '/api/v1/users', data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->user(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->user(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $data[$key]);
        }
    }

    /**
     * Verifica um retorno com sucesso para o end point update
     *
     * @test
     */
    public function check_update_return_with_success(): void
    {
        $user               = User::factory()->create();

        $data               = $this->user();
        $data['id']         = $user->id;
        $data['password']   = fake()->password();


        $response = $this->token()->put(uri: '/api/v1/users/' . $user->id, data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->user(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->user(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $data[$key]);
        }
    }

    /**
     * Verifica um retorno com sucesso para o end point delete
     *
     * @test
     */
    public function check_delete_return_with_success(): void
    {
        $user               = User::factory()->create();

        $response = $this->token()->delete(uri: '/api/v1/users/' . $user->id);
        $response->assertStatus(status: 200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'metadata',
        ]);
    }

    /**
     * Retorna array com as keys de usuario com ou sem valores fake
     *
     * @param $onlyKeys
     * @return array|int[]|string[]
     */
    private function user($onlyKeys = false) {
        $data = [
            'name'                  => fake()->name(),
            'email'                 => fake()->email(),
            'phone_personal'        => fake()->phoneNumber(),
            'phone_professional'    => fake()->phoneNumber(),
            'url_photo'             => fake()->imageUrl(),
            'status'                => UserStatusEnum::ACTIVE->value,
            'general_settings'      => '{}',
        ];

        return $onlyKeys ? array_keys($data) : $data;
    }
}
