<?php

namespace Tests\Feature\Api\v1;

use Tests\AppTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Profile;

/**
 * Testa os en points do recurso usuários(profiles)
 */
class ProfilesTest extends AppTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->post(uri: '/api/v1/logout');
        Artisan::call(command: 'migrate:fresh'); // Resetando a base de dados
        $this->flushHeaders();
    }

    /**
     * Verifica um retorno com sucesso para o en point listAll
     *
     * @test
     */
    public function check_list_all_return_with_success(): void
    {
        $profiles = Profile::factory(count: 5)->create();
        $response = $this->token()->get(uri: '/api/v1/profiles');
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.profiles.list_all_success'));
        $response->assertJsonCount(count: 5, key: 'data'); // Um usuário é criado dentro de $this->token()
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [$this->profile(onlyKeys: true)],
            'metadata'
        ]);

        $keys = $this->profile(onlyKeys: true);
        foreach ($profiles as $k => $profile) {
            foreach ($keys as $key) {
                $response->assertJsonPath(path: "data.$k.$key", expect: $profile->$key);
            }
        }
    }

    /**
     * Verifica um retorno com sucesso para o en point findById
     *
     * @test
     */
    public function check_find_by_id_return_with_success(): void
    {
        $profile = Profile::factory()->create();
        $response = $this->token()->get(uri: '/api/v1/profiles/' . $profile->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.profiles.find_by_id_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->profile(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->profile(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $profile->$key);
        }
    }

    /**
     * Verifica um retorno de id não encontrado para o en point findById
     *
     * @test
     */
    public function check_find_by_id_return_id_not_exists(): void
    {
        $response = $this->token()->get(uri: '/api/v1/profiles/99999');
        $response->assertStatus(status: 400);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.profiles.no_records_found'));
    }

    /**
     * Verifica um retorno com sucesso para o en point create
     *
     * @test
     */
    public function check_create_return_with_success(): void
    {
        $data = $this->profile();
        $data['password'] = fake()->password();

        $response = $this->token()->post(uri: '/api/v1/profiles', data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.profiles.create_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->profile(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->profile(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $data[$key]);
        }
    }

    /**
     * Verifica um retorno com sucesso para o en point update
     *
     * @test
     */
    public function check_update_return_with_success(): void
    {
        $profile               = Profile::factory()->create();

        $data               = $this->profile();
        $data['id']         = $profile->id;
        $data['password']   = fake()->password();


        $response = $this->token()->put(uri: '/api/v1/profiles/' . $profile->id, data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.profiles.update_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->profile(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->profile(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $data[$key]);
        }
    }

    /**
     * Verifica um retorno com sucesso para o en point delete
     *
     * @test
     */
    public function check_delete_return_with_success(): void
    {
        $profile               = Profile::factory()->create();

        $response = $this->token()->delete(uri: '/api/v1/profiles/' . $profile->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.profiles.delete_success'));
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
    private function profile($onlyKeys = false) {
        $data = [
            'name'                  => fake()->name(),
        ];

        return $onlyKeys ? array_keys($data) : $data;
    }
}
