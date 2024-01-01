<?php

namespace Tests\Feature\Api\v1;

use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use App\Models\EventList;
use App\Models\EventListItem;
use App\Models\SaasClient;
use Tests\AppTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Event;

/**
 * Testa os en points do recurso Eventos (events)
 */
class EventsListsItemsTest extends AppTestCase
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
        $saasClient         = SaasClient::factory()->create();
        $event1             = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $event2             = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $eventList1         = EventList::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event1->id]);
        $eventList2         = EventList::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event2->id]);
        $eventsListsItems   = EventListItem::factory(count: 5)->create(['saas_client_id' => $saasClient->id, 'event_id' => $event1->id, 'event_list_id' => $eventList1->id]);
        EventListItem::factory(count: 5)->create(['saas_client_id' => $saasClient->id, 'event_id' => $event2->id, 'event_list_id' => $eventList2->id]);

        $response = $this->token()->get(uri: '/api/v1/events-lists-items?filters[event_id][$eq]=' . $event1->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists_items.list_all_success'));
        $response->assertJsonCount(count: 5, key: 'data'); // Um usuário é criado dentro de $this->token()
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [$this->eventListItem(onlyKeys: true)],
            'metadata'
        ]);

        $keys = $this->eventListItem(onlyKeys: true);
        foreach ($eventsListsItems as $k => $eventListItem) {
            foreach ($keys as $key) {
                $response->assertJsonPath(path: "data.$k.$key", expect: $eventListItem->$key);
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
        $saasClient         = SaasClient::factory()->create();
        $event              = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $eventList          = EventList::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event->id]);
        $eventListItem      = EventListItem::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event->id, 'event_list_id' => $eventList->id]);

        $response = $this->token()->get(uri: '/api/v1/events-lists-items/' . $eventListItem->id);

        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists_items.find_by_id_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->eventListItem(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->eventListItem(onlyKeys: true);
        foreach ($keys as $key) {
            $response->assertJsonPath(path: "data.$key", expect: $eventListItem->$key);
        }
    }

    /**
     * Verifica um retorno de id não encontrado para o en point findById
     *
     * @test
     */
    public function check_find_by_id_return_id_not_exists(): void
    {
        $response = $this->token()->get(uri: '/api/v1/events-lists-items/99999');
        $response->assertStatus(status: 400);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists_items.no_records_found'));
    }

    /**
     * Verifica um retorno com sucesso para o en point create
     *
     * @test
     */
    public function check_create_return_with_success(): void
    {
        $saasClient = SaasClient::factory()->create();
        $event = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $eventList = EventList::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event->id]);

        $data = $this->eventListItem();
        $data['saas_client_id'] = $saasClient->id;
        $data['event_id'] = $event->id;
        $data['event_list_id'] = $eventList->id;

        $response = $this->token()->post(uri: '/api/v1/events-lists-items', data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists_items.create_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->eventListItem(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->eventListItem(onlyKeys: true);
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
        $saasClient             = SaasClient::factory()->create();
        $event                  = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $eventList              = EventList::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event->id]);
        $eventListItem          = EventListItem::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event->id, 'event_list_id' => $eventList->id]);

        $data                   = $this->eventListItem();
        $data['id']             = $eventListItem->id;
        $data['saas_client_id'] = $saasClient->id;
        $data['event_id']       = $event->id;
        $data['event_list_id']  = $eventList->id;


        $response = $this->token()->put(uri: '/api/v1/events-lists-items/' . $eventListItem->id, data: $data);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists_items.update_success'));
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => $this->eventListItem(onlyKeys: true),
            'metadata'
        ]);

        $keys = $this->eventListItem(onlyKeys: true);
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
        $saasClient     = SaasClient::factory()->create();
        $event          = Event::factory()->create(['saas_client_id' => $saasClient->id]);
        $eventList      = EventList::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event->id]);
        $eventListItem  = EventListItem::factory()->create(['saas_client_id' => $saasClient->id, 'event_id' => $event->id, 'event_list_id' => $eventList->id]);

        $response = $this->token()->delete(uri: '/api/v1/events-lists-items/' . $eventListItem->id);
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.events_lists_items.delete_success'));
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
    private function eventListItem($onlyKeys = false) {
        $data = [
            'name'              => fake()->name(),
            'email'             => fake()->email(),
            'phone'             => fake()->phoneNumber(),
            'payment_status'    => EventListItemPaymentStatusEnum::PENDING->value,
        ];

        return $onlyKeys ? array_keys($data) : $data;
    }
}
