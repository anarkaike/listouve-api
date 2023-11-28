<?php

namespace Tests\Feature\Api\v1;

use App\Models\EventList;
use App\Models\SaasClient;
use Tests\AppTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Event;

/**
 * Testa os en points do recurso Eventos (events)
 */
class EventsListsTest extends AppTestCase
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
        $eventsLists = EventList::factory(count: 5)->create();
        $response = $this->token()->get(uri: '/api/v1/events-lists');
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.list_all_success'));
        $response->assertJsonCount(count: 5, key: 'data'); // Um usuário é criado dentro de $this->token()
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [$this->eventList(onlyKeys: true)],
            'metadata'
        ]);

        $keys = $this->eventList(onlyKeys: true);
        foreach ($eventsLists as $k => $eventList) {
            foreach ($keys as $key) {
                $response->assertJsonPath(path: "data.$k.$key", expect: $eventList->$key);
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
        $eventList = EventList::factory()->create();
        $response = $this->token()->get(uri: '/api/v1/events-lists/' . $eventList->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.find_by_id_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->eventList(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->eventList(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $eventList->$key);
        }
    }

    /**
     * Verifica um retorno com sucesso para o en point findById
     *
     * @test
     */
    public function check_find_by_id_return_id_not_exists(): void
    {
        $response = $this->token()->get(uri: '/api/v1/events-lists/99999');
        $response->assertStatus(status: 400);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.no_records_found'));
    }

    /**
     * Verifica um retorno com sucesso para o en point create
     *
     * @test
     */
    public function check_create_return_with_success(): void
    {
        $data = $this->eventList();

        $response = $this->token()->post(uri: '/api/v1/events-lists', data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.create_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->eventList(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->eventList(onlyKeys: true);
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
        $event               = EventList::factory()->create();

        $data               = $this->eventList();
        $data['id']         = $event->id;


        $response = $this->token()->put(uri: '/api/v1/events-lists/' . $event->id, data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.update_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->eventList(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->eventList(onlyKeys: true);
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
        $event               = EventList::factory()->create();

        $response = $this->token()->delete(uri: '/api/v1/events-lists/' . $event->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.delete_success'));
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
    private function eventList($onlyKeys = false) {
        $data = [
            'saas_client_id'    => $saasClientId = SaasClient::factory()->create()->id,
            'event_id'          => Event::factory()->create(['saas_client_id' => $saasClientId,])->id,
            'name'              => fake()->name(),
            'description'       => fake()->text(),
            'url_photo'         => fake()->imageUrl(),
        ];

        return $onlyKeys ? array_keys($data) : $data;
    }
}
