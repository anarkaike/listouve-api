<?php

namespace Tests\Feature\Api\v1;

use App\Models\SaasClient;
use Tests\AppTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Event;

/**
 * Testa os en points do recurso Eventos (events)
 */
class EventsTest extends AppTestCase
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
        $events = Event::factory(count: 5)->create();
        $response = $this->token()->get(uri: '/api/v1/events');
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events.list_all_success'));
        $response->assertJsonCount(count: 5, key: 'data'); // Um usuário é criado dentro de $this->token()
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [$this->event(onlyKeys: true)],
            'metadata'
        ]);

        $keys = $this->event(onlyKeys: true);
        foreach ($events as $k => $event) {
            foreach ($keys as $key) {
                $response->assertJsonPath(path: "data.$k.$key", expect: $event->$key);
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
        $event = Event::factory()->create();
        $response = $this->token()->get(uri: '/api/v1/events/' . $event->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events.find_by_id_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->event(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->event(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $event->$key);
        }
    }


    /**
     * Verifica um retorno de id não encontrado para o en point findById
     *
     * @test
     */
    public function check_find_by_id_return_id_not_exists(): void
    {
        $response = $this->token()->get(uri: '/api/v1/events/99999');
        $response->assertStatus(status: 400);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events.no_records_found'));
    }

    /**
     * Verifica um retorno com sucesso para o en point create
     *
     * @test
     */
    public function check_create_return_with_success(): void
    {
        $data = $this->event();

        $response = $this->token()->post(uri: '/api/v1/events', data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events.create_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->event(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->event(onlyKeys: true);
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
        $event               = Event::factory()->create();

        $data               = $this->event();
        $data['id']         = $event->id;


        $response = $this->token()->put(uri: '/api/v1/events/' . $event->id, data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events.update_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->event(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->event(onlyKeys: true);
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
        $event               = Event::factory()->create();

        $response = $this->token()->delete(uri: '/api/v1/events/' . $event->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events.delete_success'));
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
    private function event($onlyKeys = false) {
        $data = [
            'name'              => fake()->name(),
            'description'       => fake()->text(),
            'url_photo'         => fake()->imageUrl(),
            'saas_client_id'    => SaasClient::factory()->create()->id,
        ];

        return $onlyKeys ? array_keys($data) : $data;
    }
}
