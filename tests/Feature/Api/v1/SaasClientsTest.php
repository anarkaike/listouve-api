<?php

namespace Tests\Feature\Api\v1;

use App\Enums\SaasClient\SaasClientStatusEnum;
use App\Models\SaasClient;
use Tests\AppTestCase;
use Illuminate\Support\Facades\Artisan;

/**
 * Testa os end points do recurso Eventos (events)
 */
class SaasClientsTest extends AppTestCase
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
        $saasClients = SaasClient::factory(count: 5)->create();
        $response = $this->token()->get(uri: '/api/v1/saas-clients');
        $response->assertStatus(status: 200);
        $response->assertJsonCount(count: 5, key: 'data'); // Um usuário é criado dentro de $this->token()
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [$this->saasClient(onlyKeys: true)],
            'metadata'
        ]);

        $keys = $this->saasClient(onlyKeys: true);
        foreach ($saasClients as $k => $saasClient) {
            foreach ($keys as $key) {
                $response->assertJsonPath(path: "data.$k.$key", expect: $saasClient->$key);
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
        $saasClient = SaasClient::factory()->create();
        $response = $this->token()->get(uri: '/api/v1/saas-clients/' . $saasClient->id);
        $response->assertStatus(status: 200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->saasClient(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->saasClient(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $saasClient->$key);
        }
    }

    /**
     * Verifica um retorno com sucesso para o end point create
     *
     * @test
     */
    public function check_create_return_with_success(): void
    {
        $data = $this->saasClient();

        $response = $this->token()->post(uri: '/api/v1/saas-clients', data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->saasClient(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->saasClient(onlyKeys: true);
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
        $event               = SaasClient::factory()->create();

        $data               = $this->saasClient();
        $data['id']         = $event->id;


        $response = $this->token()->put(uri: '/api/v1/saas-clients/' . $event->id, data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->saasClient(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->saasClient(onlyKeys: true);
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
        $event               = SaasClient::factory()->create();

        $response = $this->token()->delete(uri: '/api/v1/saas-clients/' . $event->id);
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
    private function saasClient($onlyKeys = false) {
        $data = [
            'name'              => fake()->name(),
            'email_personal'    => fake()->email(),
            'email_pofessional' => fake()->email(),
            'phone_personal'    => fake()->phoneNumber(),
            'phone_pofessional' => fake()->phoneNumber(),
            'observation'       => fake()->text(),
            'status'            => SaasClientStatusEnum::ACTIVE->value,
            'general_settings'  => '{}',
        ];

        return $onlyKeys ? array_keys($data) : $data;
    }
}
