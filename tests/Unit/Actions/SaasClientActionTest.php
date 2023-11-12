<?php

namespace Tests\Unit\Actions;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\{
    Actions\SaasClientAction,
    Enums\SaasClient\SaasClientStatusEnum,
    Models\SaasClient,
    Repositories\SaasClientRepository,
};

class SaasClientActionTest extends TestCase
{

    /**
     * Verifica se o metodo SaasClientRepository->listAll() retorna o valor correto
     * @test
     */
    public function check_if_return_list_all_is_correct(): void
    {
        $expectedValue = ['1', '2', '3'];

        $repositoryMocked = Mockery::mock(args: SaasClientRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'listAll')->andReturn(args: $expectedValue);


        $actionToTest = new SaasClientAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->listAll();
        $arrayDiff = array_diff($expectedValue, $actualValue);

        $this->assertEquals(expected: 0, actual: count($arrayDiff), message: 'O retorno do metodo listAll do action não está correto.');
    }

    /**
     * Verifica se o metodo SaasClientAction->findById(id: $id) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_find_by_id_is_correct(): void
    {
        $idToFind = fake()->randomNumber(1,9999);

        $modelMockedExpected = $this->createPartialMock(originalClassName: SaasClient::class, methods: ['fill', 'setAttribute']);
        $modelMockedExpected->id = $idToFind;
        $modelMockedExpected->name = fake()->name();
        $modelMockedExpected->email_personal = fake()->email();
        $modelMockedExpected->email_pofessional = fake()->email();
        $modelMockedExpected->phone_personal = fake()->phoneNumber();
        $modelMockedExpected->phone_pofessional = fake()->phoneNumber();
        $modelMockedExpected->observation = fake()->text();
        $modelMockedExpected->status = SaasClientStatusEnum::ACTIVE->value;

        $repositoryMocked = Mockery::mock(args: SaasClientRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'findById')->with($idToFind)->andReturn(args: $modelMockedExpected);

        $actionToTest = new SaasClientAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->findById(id: $idToFind);

        $this->assertEquals(expected: $modelMockedExpected->toArray(), actual: $actualValue->toArray(), message: 'O retorno do metodo findById do action não está correto.');
    }

    /**
     * Verifica se o metodo SaasClientAction->create(data: $data, createdBy: $createdBy) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_create_is_correct(): void
    {
        $data = [
            'id' => fake()->randomNumber(1,9999),
            'name' => fake()->name(),
            'email_personal' => fake()->email(),
            'email_pofessional' => fake()->email(),
            'phone_personal' => fake()->phoneNumber(),
            'phone_pofessional' => fake()->phoneNumber(),
            'observation' => fake()->text(),
            'status' => SaasClientStatusEnum::ACTIVE->value,
            'created_by' => fake()->randomNumber(1,9999),
        ];

        $modelMockedExpected = $this->createPartialMock(originalClassName: SaasClient::class, methods: ['fill', 'setAttribute']);
        $modelMockedExpected->id = $data['id'];
        $modelMockedExpected->name = $data['name'];
        $modelMockedExpected->email_personal = $data['email_personal'];
        $modelMockedExpected->email_pofessional = $data['email_pofessional'];
        $modelMockedExpected->phone_personal = $data['phone_personal'];
        $modelMockedExpected->phone_pofessional = $data['phone_pofessional'];
        $modelMockedExpected->observation = $data['observation'];
        $modelMockedExpected->status = $data['status'];

        $repositoryMocked = Mockery::mock(args: SaasClientRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'create')->with($data)->andReturn(args: $modelMockedExpected);

        $actionToTest = new SaasClientAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->create($data);

        $this->assertEquals(expected: $modelMockedExpected->toArray(), actual: $actualValue->toArray(), message: 'O retorno do metodo create do action não está correto.');
    }

    /**
     * Verifica se o metodo SaasClientAction->update(data: $data, updatedBy: $updatedBy) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_update_is_correct(): void
    {
        $data = [
            'id' => fake()->randomNumber(1,9999),
            'name' => fake()->name(),
            'email_personal' => fake()->email(),
            'email_pofessional' => fake()->email(),
            'phone_personal' => fake()->phoneNumber(),
            'phone_pofessional' => fake()->phoneNumber(),
            'observation' => fake()->text(),
            'status' => SaasClientStatusEnum::ACTIVE->value,
            'updated_by' => fake()->randomNumber(1,9999),
        ];

        $modelMockedExpected = $this->createPartialMock(originalClassName: SaasClient::class, methods: ['fill', 'setAttribute']);
        $modelMockedExpected->id = $data['id'];
        $modelMockedExpected->name = $data['name'];
        $modelMockedExpected->email_personal = $data['email_personal'];
        $modelMockedExpected->email_pofessional = $data['email_pofessional'];
        $modelMockedExpected->phone_personal = $data['phone_personal'];
        $modelMockedExpected->phone_pofessional = $data['phone_pofessional'];
        $modelMockedExpected->observation = $data['observation'];
        $modelMockedExpected->status = $data['status'];

        $repositoryMocked = Mockery::mock(args: SaasClientRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'update')->with((int) $data['id'], (array) $data)->andReturn(args: $modelMockedExpected);

        $actionToTest = new SaasClientAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->update((int) $data['id'], (array) $data);

        $this->assertEquals(expected: $modelMockedExpected->toArray(), actual: $actualValue->toArray(), message: 'O retorno do metodo update do action não está correto.');
    }

    /**
     * Verifica se o metodo SaasClientAction->delete(id: $id, deletedBy: $deletedBy) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_delete_is_correct(): void
    {
        $idToDelete = fake()->randomNumber(1,9999);
        $deletedBy = fake()->randomNumber(1,9999);

        $repositoryMocked = Mockery::mock(args: SaasClientRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'delete')->with($idToDelete, $deletedBy)->andReturnTrue();

        $actionToTest = new SaasClientAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->delete($idToDelete, $deletedBy);

        $this->assertTrue(condition: $actualValue, message: 'O retorno do metodo delete do action não está correto.');
    }
}
