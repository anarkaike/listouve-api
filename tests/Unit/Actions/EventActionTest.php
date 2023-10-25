<?php

namespace Tests\Unit\Actions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use App\{Actions\EventAction,
    Contracts\Repositories\EventRepositoryInterface,
    Models\Event,
    Models\SaasClient,
    Repositories\EventRepository};

class EventActionTest extends TestCase
{
    private $saasClient = null;

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->app->bind(abstract: EventRepositoryInterface::class, concrete: EventRepository::class);
        if (is_null($this->saasClient)) $this->saasClient = SaasClient::factory()->create();
    }

    public function test_list_all()
    {
        // Criando um evento para usar nos testes
        $event = Event::factory()->create(attributes: ['saas_client_id' => $this->saasClient->id]);

        // Criando uma instância de EventAction com um repositório real (não um mock)
        $eventRepository = $this->app->make(abstract: EventRepositoryInterface::class);
        $eventAction = new EventAction(eventRepository: $eventRepository);

        // Testando o método listAll
        $result = $eventAction->listAll();

        // Testando se o resultado contém o evento que criamos
        $this->assertTrue(condition: $result->contains($event));
    }

    public function test_find_by_id()
    {
        // Criando um evento para usar nos testes
        $event = Event::factory()->create(attributes: ['saas_client_id' => $this->saasClient->id]);

        // Criando uma instância de EventAction com um repositório real (não um mock)
        $eventRepository = $this->app->make(abstract: EventRepositoryInterface::class);
        $eventAction = new EventAction(eventRepository: $eventRepository);

        // Chamando o método listAll
        $eventFound = $eventAction->findById(id: $event->id);

        // Testando se o resultado contém o evento que criamos
        $this->assertEquals(expected: $event->id, actual: $eventFound->id);
        $this->assertEquals(expected: $event->name, actual: $eventFound->name);
        $this->assertEquals(expected: $event->description, actual: $eventFound->description);
        $this->assertEquals(expected: $event->url_photo, actual: $eventFound->url_photo);

        // Tentando encontrar um evento com um ID inexistente
        // e testando se lança ModelNotFoundException
//        $this->expectException(exception: ModelNotFoundException::class);
//        $eventAction->findById(id: 9999);
    }

    public function teste_create()
    {
        // Dados do evento que você vamos criar
        $eventData = [
            'name' => fake()->name(),
            'description' => fake()->text(maxNbChars: 500),
            'url_photo' => fake()->imageUrl(),
            'saas_client_id' => $this->saasClient->id,
        ];

        // Criando uma instância de EventAction com um repositório real (não um mock)
        $eventRepository = $this->app->make(abstract: EventRepositoryInterface::class);
        $eventAction = new EventAction(eventRepository: $eventRepository);

        // Chamando o método create
        $createdEvent = $eventAction->create(data: $eventData);

        // Testando se o evento foi criado corretamente no base de dados
//        $this->assertDatabaseHas(table: 'events',
//            data: [
//                'name' => $eventData['name'],
//                'description' => $eventData['description'],
//                'url_photo' => $eventData['url_photo'],
//            ]
//        );

        // Testando se os dados do evento criado correspondem aos dados fornecidos
        $this->assertEquals(expected: $eventData['name'], actual: $createdEvent->name);
        $this->assertEquals(expected: $eventData['description'], actual: $createdEvent->description);
        $this->assertEquals(expected: $eventData['url_photo'], actual: $createdEvent->url_photo);
    }

    public function teste_update()
    {
        // Criando um evento para usar nos testes
        $event = Event::factory()->create(attributes: ['saas_client_id' => 0]);

        // Dados novos para atualizar o registro na base de dados
        $updatedData = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'description' => fake()->text(maxNbChars: 500),
            'url_photo' => fake()->imageUrl(),
            'saas_client_id' => $this->saasClient->id,
        ];

        // Criando uma instância de EventAction com um repositório real (não um mock)
        $eventRepository = $this->app->make(abstract: EventRepositoryInterface::class);
        $eventAction = new EventAction($eventRepository);

        $updatedEvent = $eventAction->update(id: $event->id, data: $updatedData);

        // testando se os dados do evento foram atualizados corretamente na base de dados
//        $this->assertDatabaseHas(table: 'events', data: [
//            'id' => $event->id,
//            'name' => $updatedData['name'],
//            'description' => $updatedData['description'],
//            'url_photo' => $updatedData['url_photo'],
//        ]);

        // Testando se os dados do evento atualizado correspondem aos dados fornecidos
        $this->assertEquals(expected: $updatedData['name'], actual: $updatedEvent->name);
        $this->assertEquals(expected: $updatedData['description'], actual: $updatedEvent->description);
    }

    public function test_delete()
    {
        // Criando um evento para usar nos testes
        $event = Event::factory()->create(['saas_client_id' => $this->saasClient->id]);

        // Criando uma instância de EventAction com um repositório real (não um mock)
        $eventRepository = $this->app->make(abstract: EventRepositoryInterface::class);
        $eventAction = new EventAction(eventRepository: $eventRepository);

        // Chamando o método delete para remover o evento
        $deleted = $eventAction->delete(id: $event->id);

        // testando se o método delete retornou true, indicando que a exclusão foi bem-sucedida
        $this->assertTrue(condition: $deleted);

        // Tentando encontrar o evento excluído
        // e testando se lança ModelNotFoundException
//        $this->expectException(exception: ModelNotFoundException::class);
//        Event::findOrFail($event->id); // Deve lançar uma exceção
    }
}
