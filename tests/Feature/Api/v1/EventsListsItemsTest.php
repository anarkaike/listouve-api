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
        $eventsListsItems = EventListItem::factory(count: 5)->create();
        $response = $this->token()->get(uri: '/api/v1/events-lists-items');
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
        $eventListItem = EventListItem::factory()->create();
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
        $data = $this->eventListItem();

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
        $event               = EventListItem::factory()->create();

        $data               = $this->eventListItem();
        $data['id']         = $event->id;


        $response = $this->token()->put(uri: '/api/v1/events-lists-items/' . $event->id, data: $data);
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
        $event               = EventListItem::factory()->create();

        $response = $this->token()->delete(uri: '/api/v1/events-lists-items/' . $event->id);
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
            'saas_client_id'    => $saasClientId = SaasClient::factory()->create()->id,
            'name'              => fake()->name(),
            'email'             => fake()->email(),
            'phone'             => fake()->phoneNumber(),
            'event_id'          => $eventId = Event::factory()->create(['saas_client_id' => $saasClientId,])->id,
            'event_list_id'     => EventList::factory()->create(['event_id' => $eventId, 'saas_client_id' => $saasClientId,])->id,
            'payment_status'    => EventListItemPaymentStatusEnum::PAID->value,
        ];

        return $onlyKeys ? array_keys($data) : $data;
    }
}
