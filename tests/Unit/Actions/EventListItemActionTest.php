<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\{Actions\EventListItemAction,
    Contracts\Repositories\EventListItemRepositoryInterface,
    Models\Event,
    Models\EventListItem,
    Models\SaasClient,
};

class EventListItemActionTest extends TestCase
{
    private ?SaasClient $saasClient = null;

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function setUp(): void
    {
        parent::setUp();
        if (is_null($this->saasClient)) $this->saasClient = SaasClient::factory()->create();
        if (is_null($this->event)) $this->event = Event::factory()->create(attributes: [
            'saas_client_id' => $this->event->id,
        ]);
        if (is_null($this->eventList)) $this->eventList = Event::factory()->create(attributes: [
            'saas_client_id' => $this->event->id,
            'event_list_id' => $this->eventList->id,
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
        $this->assertEquals(expected: $eventListItem->description, actual: $eventListItemFound->description);
        $this->assertEquals(expected: $eventListItem->url_photo, actual: $eventListItemFound->url_photo);
    }

    public function teste_create()
    {
        // Dados do eventListItemo que você vamos criar
        $eventListItemData = [
            'name' => fake()->name(),
            'description' => fake()->text(maxNbChars: 500),
            'url_photo' => fake()->imageUrl(),
            'saas_client_id' => $this->saasClient->id,
            'event_id' => $this->event->id,
            'event_list_id' => $this->eventList->id,
        ];

        // Criando uma instância de EventListItemAction com um repositório real (não um mock)
        $eventListItemRepository = $this->app->make(abstract: EventListItemRepositoryInterface::class);
        $eventListItemAction = new EventListItemAction(eventListItemRepository: $eventListItemRepository);

        // Chamando o método create
        $createdEventListItem = $eventListItemAction->create(data: $eventListItemData);

        // Testando se os dados do eventListItemo criado correspondem aos dados fornecidos
        $this->assertEquals(expected: $eventListItemData['name'], actual: $createdEventListItem->name);
        $this->assertEquals(expected: $eventListItemData['description'], actual: $createdEventListItem->description);
        $this->assertEquals(expected: $eventListItemData['url_photo'], actual: $createdEventListItem->url_photo);
    }

    public function teste_update()
    {
        // Criando um eventListItemo para usar nos testes
        $eventListItem = EventListItem::factory()->create(attributes: ['saas_client_id' => 0]);

        // Dados novos para atualizar o registro na base de dados
        $updatedData = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'description' => fake()->text(maxNbChars: 500),
            'url_photo' => fake()->imageUrl(),
            'saas_client_id' => $this->saasClient->id,
            'event_id' => $this->event->id,
            'event_list_id' => $this->eventList->id,
        ];

        // Criando uma instância de EventListItemAction com um repositório real (não um mock)
        $eventListItemRepository = $this->app->make(abstract: EventListItemRepositoryInterface::class);
        $eventListItemAction = new EventListItemAction($eventListItemRepository);

        $updatedEventListItem = $eventListItemAction->update(id: $eventListItem->id, data: $updatedData);

        // Testando se os dados do eventListItemo atualizado correspondem aos dados fornecidos
        $this->assertEquals(expected: $updatedData['name'], actual: $updatedEventListItem->name);
        $this->assertEquals(expected: $updatedData['description'], actual: $updatedEventListItem->description);
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
