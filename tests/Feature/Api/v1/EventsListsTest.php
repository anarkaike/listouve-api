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
        $saasClient     = SaasClient::factory()->create();
        $event1         = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $event2         = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $eventsLists1   = EventList::factory(count: 5)->create(['saas_client_id' => $saasClient->id, 'event_id' => $event1->id]);
        EventList::factory(count: 5)->create(['saas_client_id' => $saasClient->id, 'event_id' => $event2->id]);

        $response = $this->token()->get(uri: '/api/v1/events-lists?filters[event_id][$eq]=' . $event1->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.list_all_success'));
        $response->assertJsonCount(count: 5, key: 'data'); // Um usuário é criado dentro de $this->token()
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [$this->eventListFake(onlyKeys: true)],
            'metadata'
        ]);

        $keys = $this->eventListFake(onlyKeys: true);
        foreach ($eventsLists1 as $k => $eventList) {
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
        $saasClient = SaasClient::factory()->create();
        $event      = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $eventList  = EventList::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event->id]);

        $response = $this->token()->get(uri: '/api/v1/events-lists/' . $eventList->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.find_by_id_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->eventListFake(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->eventListFake(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $eventList->$key);
        }
    }

    /**
     * Verifica um retorno de id não encontrado para o en point findById
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
        $saasClient = SaasClient::factory()->create();
        $event      = Event::factory()->create(['saas_client_id' => $saasClient->id]);

        $data = $this->eventListFake();
        $data['saas_client_id'] = $saasClient->id;
        $data['event_id'] = $event->id;

        $response = $this->token()->post(uri: '/api/v1/events-lists', data: $data);

        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.create_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->eventListFake(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->eventListFake(onlyKeys: true);
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
        $saasClient = SaasClient::factory()->create();
        $event      = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $eventList  = EventList::factory()->create(['event_id' => $event->id, 'saas_client_id' => $saasClient->id]);

        $data       = $this->eventListFake();

        $response = $this->token()->put(uri: '/api/v1/events-lists/' . $eventList->id, data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists.update_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->eventListFake(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->eventListFake(onlyKeys: true);
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
        $saasClient = SaasClient::factory()->create();
        $event      = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $eventList  = EventList::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event->id]);

        $response = $this->token()->delete(uri: '/api/v1/events-lists/' . $eventList->id);
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
    private function eventListFake($onlyKeys = false) {
        $data = [
            'name'              => fake()->name(),
            'description'       => fake()->text(),
            'url_photo'         => fake()->imageUrl(),
        ];

        return $onlyKeys ? array_keys($data) : $data;
    }
}
