<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\{
    Actions\SaasClientAction,
    Contracts\Repositories\SaasClientRepositoryInterface,
    Enums\SaasClient\SaasClientEnum,
    Models\SaasClient,
};

/**
 * Testes para SaasClientAction
 */
class SaasClientActionTest extends TestCase
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_list_all()
    {
        // Criando um saasCliento para usar nos testes
        $saasClient = SaasClient::factory()->create();

        // Criando uma instância de SaasClientAction com um repositório real (não um mock)
        $saasClientRepository = $this->app->make(abstract: SaasClientRepositoryInterface::class);
        $saasClientAction = new SaasClientAction(saasClientRepository: $saasClientRepository);

        // Testando o método listAll
        $result = $saasClientAction->listAll();

        // Testando se o resultado contém o saasCliento que criamos
        $this->assertTrue(condition: $result->contains($saasClient));
    }

    public function test_find_by_id()
    {
        // Criando um saasCliento para usar nos testes
        $saasClient = SaasClient::factory()->create();

        // Criando uma instância de SaasClientAction com um repositório real (não um mock)
        $saasClientRepository = $this->app->make(abstract: SaasClientRepositoryInterface::class);
        $saasClientAction = new SaasClientAction(saasClientRepository: $saasClientRepository);

        // Chamando o método listAll
        $saasClientFound = $saasClientAction->findById(id: $saasClient->id);

        // Testando se o resultado contém o saasCliento que criamos
        $this->assertEquals(expected: $saasClient->id, actual: $saasClientFound->id);
        $this->assertEquals(expected: $saasClient->name, actual: $saasClientFound->name);
        $this->assertEquals(expected: $saasClient->email_personal, actual: $saasClientFound->email_personal);
        $this->assertEquals(expected: $saasClient->email_pofessional, actual: $saasClientFound->email_pofessional);
        $this->assertEquals(expected: $saasClient->phone_personal, actual: $saasClientFound->phone_personal);
        $this->assertEquals(expected: $saasClient->phone_pofessional, actual: $saasClientFound->phone_pofessional);
        $this->assertEquals(expected: $saasClient->observation, actual: $saasClientFound->observation);
        // $this->assertEquals(expected: $saasClient->status, actual: $saasClientFound->status);
    }

    public function teste_create()
    {
        // Dados do saasCliento que você vamos criar
        $saasClientData = [
            'name' => fake()->name(),
            'email_personal' => fake()->email(),
            'email_pofessional' => fake()->email(),
            'phone_personal' => fake()->phoneNumber(),
            'phone_pofessional' => fake()->phoneNumber(),
            'observation' => fake()->text(500),
            'status' => SaasClientEnum::ACTIVE->value,
        ];

        // Criando uma instância de SaasClientAction com um repositório real (não um mock)
        $saasClientRepository = $this->app->make(abstract: SaasClientRepositoryInterface::class);
        $saasClientAction = new SaasClientAction(saasClientRepository: $saasClientRepository);

        // Chamando o método create
        $createdSaasClient = $saasClientAction->create(data: $saasClientData);

        // Testando se os dados do saasCliento criado correspondem aos dados fornecidos
        $this->assertEquals(expected: $saasClientData['name'], actual: $createdSaasClient->name);
        $this->assertEquals(expected: $saasClientData['email_personal'], actual: $createdSaasClient->email_personal);
        $this->assertEquals(expected: $saasClientData['email_pofessional'], actual: $createdSaasClient->email_pofessional);
        $this->assertEquals(expected: $saasClientData['phone_personal'], actual: $createdSaasClient->phone_personal);
        $this->assertEquals(expected: $saasClientData['phone_pofessional'], actual: $createdSaasClient->phone_pofessional);
        $this->assertEquals(expected: $saasClientData['observation'], actual: $createdSaasClient->observation);
        $this->assertEquals(expected: $saasClientData['status'], actual: $createdSaasClient->status);
    }

    public function teste_update()
    {
        // Criando um saasCliento para usar nos testes
        $saasClient = SaasClient::factory()->create();

        // Dados novos para atualizar o registro na base de dados
        $updatedData = [
            'name' => fake()->name(),
            'email_personal' => fake()->email(),
            'email_pofessional' => fake()->email(),
            'phone_personal' => fake()->phoneNumber(),
            'phone_pofessional' => fake()->phoneNumber(),
            'observation' => fake()->text(500),
            'status' => SaasClientEnum::ACTIVE->value,
        ];

        // Criando uma instância de SaasClientAction com um repositório real (não um mock)
        $saasClientRepository = $this->app->make(abstract: SaasClientRepositoryInterface::class);
        $saasClientAction = new SaasClientAction($saasClientRepository);

        $updatedSaasClient = $saasClientAction->update(id: $saasClient->id, data: $updatedData);

        // Testando se os dados do saasCliento atualizado correspondem aos dados fornecidos
        $this->assertEquals(expected: $updatedData['name'], actual: $updatedSaasClient->name);
        $this->assertEquals(expected: $updatedData['email_personal'], actual: $updatedSaasClient->email_personal);
        $this->assertEquals(expected: $updatedData['email_pofessional'], actual: $updatedSaasClient->email_pofessional);
        $this->assertEquals(expected: $updatedData['phone_personal'], actual: $updatedSaasClient->phone_personal);
        $this->assertEquals(expected: $updatedData['phone_pofessional'], actual: $updatedSaasClient->phone_pofessional);
        $this->assertEquals(expected: $updatedData['observation'], actual: $updatedSaasClient->observation);
        $this->assertEquals(expected: $updatedData['status'], actual: $updatedSaasClient->status);
    }

    public function test_delete()
    {
        // Criando um saasCliento para usar nos testes
        $saasClient = SaasClient::factory()->create();

        // Criando uma instância de SaasClientAction com um repositório real (não um mock)
        $saasClientRepository = $this->app->make(abstract: SaasClientRepositoryInterface::class);
        $saasClientAction = new SaasClientAction(saasClientRepository: $saasClientRepository);

        // Chamando o método delete para remover o saasCliento
        $deleted = $saasClientAction->delete(id: $saasClient->id);

        // testando se o método delete retornou true, indicando que a exclusão foi bem-sucedida
        $this->assertTrue(condition: $deleted);
    }
}
