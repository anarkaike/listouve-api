<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\{Actions\EventListItemAction,
    Contracts\Repositories\EventListItemRepositoryInterface,
    Enums\EventListItem\EventListItemPaymentStatusEnum,
    Models\Event,
    Models\EventList,
    Models\EventListItem,
    Models\SaasClient};

/**
 * Testes para EventListItemAction
 */
class EventListItemActionTest extends TestCase
{
    private ?SaasClient $saasClient = null;
    private ?Event $event = null;
    private ?EventList $eventList = null;

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function setUp(): void
    {
        parent::setUp();
        if (is_null($this->saasClient)) $this->saasClient = SaasClient::factory()->create();
        if (is_null($this->event)) $this->event = Event::factory()->create(attributes: [
            'saas_client_id' => $this->saasClient->id,
        ]);
        if (is_null($this->eventList)) $this->eventList = EventList::factory()->create(attributes: [
            'saas_client_id' => $this->saasClient->id,
            'event_id' => $this->event->id,
        ]);
    }

    public function test_list_all()
    {
        // Criando um eventListItemo para usar nos testes
        $eventListItem = EventListItem::factory()->create(attributes: ['saas_client_id' => $this->saasClient->id]);

        // Criando uma instância de EventListItemAction com um repositório real (não um mock)
        $eventListItemRepository = $this->app->make(abstract: EventListItemRepositoryInterface::class);
        $eventListItemAction = new EventListItemAction(eventListItemRepository: $eventListItemRepository);

        // Testando o método listAll
        $result = $eventListItemAction->listAll();

        // Testando se o resultado contém o eventListItemo que criamos
        $this->assertTrue(condition: $result->contains($eventListItem));
    }

    public function test_find_by_id()
    {
        // Criando um eventListItemo para usar nos testes
        $eventListItem = EventListItem::factory()->create(attributes: ['saas_client_id' => $this->saasClient->id]);

        // Criando uma instância de EventListItemAction com um repositório real (não um mock)
        $eventListItemRepository = $this->app->make(abstract: EventListItemRepositoryInterface::class);
        $eventListItemAction = new EventListItemAction(eventListItemRepository: $eventListItemRepository);

        // Chamando o método listAll
        $eventListItemFound = $eventListItemAction->findById(id: $eventListItem->id);

        // Testando se o resultado contém o eventListItemo que criamos
        $this->assertEquals(expected: $eventListItem->id, actual: $eventListItemFound->id);
        $this->assertEquals(expected: $eventListItem->name, actual: $eventListItemFound->name);
        $this->assertEquals(expected: $eventListItem->email, actual: $eventListItemFound->email);
        $this->assertEquals(expected: $eventListItem->phone, actual: $eventListItemFound->phone);
        $this->assertEquals(expected: $eventListItem->event_id, actual: $eventListItemFound->event_id);
        $this->assertEquals(expected: $eventListItem->event_list_id, actual: $eventListItemFound->event_list_id);
        $this->assertEquals(expected: $eventListItem->payment_status, actual: $eventListItemFound->payment_status);
        $this->assertEquals(expected: $eventListItem->saas_client_id, actual: $eventListItemFound->saas_client_id);
    }

    public function teste_create()
    {
        // Dados do eventListItemo que você vamos criar
        $eventListItemData = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'event_id' => $this->event->id,
            'event_list_id' => $this->eventList->id,
            'description' => fake()->text(maxNbChars: 500),
            'payment_status' => EventListItemPaymentStatusEnum::PENDING->value,
            'saas_client_id' => $this->saasClient->id,
        ];

        // Criando uma instância de EventListItemAction com um repositório real (não um mock)
        $eventListItemRepository = $this->app->make(abstract: EventListItemRepositoryInterface::class);
        $eventListItemAction = new EventListItemAction(eventListItemRepository: $eventListItemRepository);

        // Chamando o método create
        $createdEventListItem = $eventListItemAction->create(data: $eventListItemData);

        // Testando se os dados do eventListItemo criado correspondem aos dados fornecidos
        $this->assertEquals(expected: $eventListItemData['name'], actual: $createdEventListItem->name);
        $this->assertEquals(expected: $eventListItemData['email'], actual: $createdEventListItem->email);
        $this->assertEquals(expected: $eventListItemData['phone'], actual: $createdEventListItem->phone);
        $this->assertEquals(expected: $eventListItemData['event_id'], actual: $createdEventListItem->event_id);
        $this->assertEquals(expected: $eventListItemData['event_list_id'], actual: $createdEventListItem->event_list_id);
        $this->assertEquals(expected: $eventListItemData['payment_status'], actual: $createdEventListItem->payment_status);
        $this->assertEquals(expected: $eventListItemData['saas_client_id'], actual: $createdEventListItem->saas_client_id);
    }

    public function teste_update()
    {
        // Criando um eventListItemo para usar nos testes
        $eventListItem = EventListItem::factory()->create(attributes: ['saas_client_id' => 0]);

        // Dados novos para atualizar o registro na base de dados
        $updatedData = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'event_id' => $this->event->id,
            'event_list_id' => $this->eventList->id,
            'description' => fake()->text(maxNbChars: 500),
            'payment_status' => EventListItemPaymentStatusEnum::PENDING->value,
            'saas_client_id' => $this->saasClient->id,
        ];

        // Criando uma instância de EventListItemAction com um repositório real (não um mock)
        $eventListItemRepository = $this->app->make(abstract: EventListItemRepositoryInterface::class);
        $eventListItemAction = new EventListItemAction($eventListItemRepository);

        $updatedEventListItem = $eventListItemAction->update(id: $eventListItem->id, data: $updatedData);

        // Testando se os dados do eventListItemo atualizado correspondem aos dados fornecidos
        $this->assertEquals(expected: $updatedData['name'], actual: $updatedEventListItem->name);
        $this->assertEquals(expected: $updatedData['email'], actual: $updatedEventListItem->email);
        $this->assertEquals(expected: $updatedData['phone'], actual: $updatedEventListItem->phone);
        $this->assertEquals(expected: $updatedData['event_id'], actual: $updatedEventListItem->event_id);
        $this->assertEquals(expected: $updatedData['event_list_id'], actual: $updatedEventListItem->event_list_id);
        $this->assertEquals(expected: $updatedData['payment_status'], actual: $updatedEventListItem->payment_status);
        $this->assertEquals(expected: $updatedData['saas_client_id'], actual: $updatedEventListItem->saas_client_id);
    }

    public function test_delete()
    {
        // Criando um eventListItemo para usar nos testes
        $eventListItem = EventListItem::factory()->create(['saas_client_id' => $this->saasClient->id]);

        // Criando uma instância de EventListItemAction com um repositório real (não um mock)
        $eventListItemRepository = $this->app->make(abstract: EventListItemRepositoryInterface::class);
        $eventListItemAction = new EventListItemAction(eventListItemRepository: $eventListItemRepository);

        // Chamando o método delete para remover o eventListItemo
        $deleted = $eventListItemAction->delete(id: $eventListItem->id);

        // testando se o método delete retornou true, indicando que a exclusão foi bem-sucedida
        $this->assertTrue(condition: $deleted);
    }
}
