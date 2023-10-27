<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\{
    Actions\EventListAction,
    Contracts\Repositories\EventListRepositoryInterface,
    Models\Event,
    Models\EventList,
    Models\SaasClient,
};

/**
 * Testes para o EventListAction
 */
class EventListActionTest extends TestCase
{
    private ?SaasClient $saasClient = null;
    private ?Event $event = null;

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function setUp(): void
    {
        parent::setUp();
        if (is_null($this->saasClient)) $this->saasClient = SaasClient::factory()->create();
        if (is_null($this->event)) $this->event = Event::factory()->create(attributes: ['saas_client_id' => $this->saasClient->id]);
    }

    public function test_list_all()
    {
        // Criando um eventListo para usar nos testes
        $eventList = EventList::factory()->create(attributes: ['saas_client_id' => $this->saasClient->id]);

        // Criando uma instância de EventListAction com um repositório real (não um mock)
        $eventListRepository = $this->app->make(abstract: EventListRepositoryInterface::class);
        $eventListAction = new EventListAction(eventListRepository: $eventListRepository);

        // Testando o método listAll
        $result = $eventListAction->listAll();

        // Testando se o resultado contém o eventListo que criamos
        $this->assertTrue(condition: $result->contains($eventList));
    }

    public function test_find_by_id()
    {
        // Criando um eventListo para usar nos testes
        $eventList = EventList::factory()->create(attributes: ['saas_client_id' => $this->saasClient->id]);

        // Criando uma instância de EventListAction com um repositório real (não um mock)
        $eventListRepository = $this->app->make(abstract: EventListRepositoryInterface::class);
        $eventListAction = new EventListAction(eventListRepository: $eventListRepository);

        // Chamando o método listAll
        $eventListFound = $eventListAction->findById(id: $eventList->id);

        // Testando se o resultado contém o eventListo que criamos
        $this->assertEquals(expected: $eventList->id, actual: $eventListFound->id);
        $this->assertEquals(expected: $eventList->event_id, actual: $eventListFound->event_id);
        $this->assertEquals(expected: $eventList->name, actual: $eventListFound->name);
        $this->assertEquals(expected: $eventList->description, actual: $eventListFound->description);
        $this->assertEquals(expected: $eventList->url_photo, actual: $eventListFound->url_photo);
    }

    public function teste_create()
    {
        // Dados do eventListo que você vamos criar
        $eventListData = [
            'event_id' => $this->event->id,
            'name' => fake()->imageUrl(),
            'description' => fake()->text(500),
            'url_photo' => fake()->imageUrl(),
            'saas_client_id' => $this->saasClient->id,
        ];

        // Criando uma instância de EventListAction com um repositório real (não um mock)
        $eventListRepository = $this->app->make(abstract: EventListRepositoryInterface::class);
        $eventListAction = new EventListAction(eventListRepository: $eventListRepository);

        // Chamando o método create
        $createdEventList = $eventListAction->create(data: $eventListData);

        // Testando se os dados do eventListo criado correspondem aos dados fornecidos
        $this->assertEquals(expected: $eventListData['event_id'], actual: $createdEventList->event_id);
        $this->assertEquals(expected: $eventListData['name'], actual: $createdEventList->name);
        $this->assertEquals(expected: $eventListData['description'], actual: $createdEventList->description);
        $this->assertEquals(expected: $eventListData['url_photo'], actual: $createdEventList->url_photo);
        $this->assertEquals(expected: $eventListData['saas_client_id'], actual: $createdEventList->saas_client_id);
    }

    public function teste_update()
    {
        // Criando um eventListo para usar nos testes
        $eventList = EventList::factory()->create(attributes: ['saas_client_id' => 0]);

        // Dados novos para atualizar o registro na base de dados
        $updatedData = [
            'event_id' => $this->event->id,
            'name' => fake()->imageUrl(),
            'description' => fake()->text(500),
            'url_photo' => fake()->imageUrl(),
            'saas_client_id' => $this->saasClient->id,
        ];

        // Criando uma instância de EventListAction com um repositório real (não um mock)
        $eventListRepository = $this->app->make(abstract: EventListRepositoryInterface::class);
        $eventListAction = new EventListAction($eventListRepository);

        $updatedEventList = $eventListAction->update(id: $eventList->id, data: $updatedData);

        // Testando se os dados do eventListo atualizado correspondem aos dados fornecidos
        $this->assertEquals(expected: $updatedData['event_id'], actual: $updatedEventList->event_id);
        $this->assertEquals(expected: $updatedData['name'], actual: $updatedEventList->name);
        $this->assertEquals(expected: $updatedData['description'], actual: $updatedEventList->description);
        $this->assertEquals(expected: $updatedData['url_photo'], actual: $updatedEventList->url_photo);
        $this->assertEquals(expected: $updatedData['saas_client_id'], actual: $updatedEventList->saas_client_id);
    }

    public function test_delete()
    {
        // Criando um eventListo para usar nos testes
        $eventList = EventList::factory()->create(['saas_client_id' => $this->saasClient->id]);

        // Criando uma instância de EventListAction com um repositório real (não um mock)
        $eventListRepository = $this->app->make(abstract: EventListRepositoryInterface::class);
        $eventListAction = new EventListAction(eventListRepository: $eventListRepository);

        // Chamando o método delete para remover o eventListo
        $deleted = $eventListAction->delete(id: $eventList->id);

        // testando se o método delete retornou true, indicando que a exclusão foi bem-sucedida
        $this->assertTrue(condition: $deleted);
    }
}
