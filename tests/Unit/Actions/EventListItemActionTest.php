<?php

namespace Tests\Unit\Actions;

use App\Actions\EventListItemAction;
use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use App\Models\EventListItem;
use App\Repositories\EventListItemRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class EventListItemActionTest extends TestCase
{

    /**
     * Verifica se o metodo EventListItemRepository->listAll() retorna o valor correto
     * @test
     */
    public function check_if_return_list_all_is_correct(): void
    {
        $expectedValue = ['1', '2', '3'];

        $repositoryMocked = Mockery::mock(args: EventListItemRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'listAll')->andReturn(args: $expectedValue);


        $actionToTest = new EventListItemAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->listAll();
        $arrayDiff = array_diff($expectedValue, $actualValue);

        $this->assertEquals(expected: 0, actual: count($arrayDiff), message: 'O retorno do metodo listAll do action não está correto.');
    }

    /**
     * Verifica se o metodo EventListItemAction->findById(id: $id) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_find_by_id_is_correct(): void
    {
        $idToFind = fake()->randomNumber(1,9999);

        $modelMockedExpected = $this->createPartialMock(originalClassName: EventListItem::class, methods: ['fill', 'setAttribute']);
        $modelMockedExpected->id = $idToFind;
        $modelMockedExpected->name = fake()->name();
        $modelMockedExpected->description = fake()->text();
        $modelMockedExpected->url_photo = fake()->imageUrl();

        $repositoryMocked = Mockery::mock(args: EventListItemRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'findById')->with($idToFind)->andReturn(args: $modelMockedExpected);

        $actionToTest = new EventListItemAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->findById(id: $idToFind);

        $this->assertEquals(expected: $modelMockedExpected->toArray(), actual: $actualValue->toArray(), message: 'O retorno do metodo findById do action não está correto.');
    }

    /**
     * Verifica se o metodo EventListItemAction->create(data: $data, createdBy: $createdBy) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_create_is_correct(): void
    {
        $data = [
            'id' => fake()->randomNumber(1,9999),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'event_id' => fake()->randomNumber(1,9999),
            'event_list_id' => fake()->randomNumber(1,9999),
            'payment_status' => EventListItemPaymentStatusEnum::PAID->value,
            'saas_client_id' => fake()->randomNumber(1,9999),
            'created_by' => fake()->randomNumber(1,9999),
        ];

        $modelMockedExpected = $this->createPartialMock(originalClassName: EventListItem::class, methods: ['fill', 'setAttribute']);
        $modelMockedExpected->id = $data['id'];
        $modelMockedExpected->name = $data['name'];
        $modelMockedExpected->email = $data['email'];
        $modelMockedExpected->phone = $data['phone'];
        $modelMockedExpected->event_id = $data['event_id'];
        $modelMockedExpected->event_list_id = $data['event_list_id'];
        $modelMockedExpected->payment_status = $data['payment_status'];
        $modelMockedExpected->saas_client_id = $data['saas_client_id'];

        $repositoryMocked = Mockery::mock(args: EventListItemRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'create')->with($data)->andReturn(args: $modelMockedExpected);

        $actionToTest = new EventListItemAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->create($data);

        $this->assertEquals(expected: $modelMockedExpected->toArray(), actual: $actualValue->toArray(), message: 'O retorno do metodo create do action não está correto.');
    }

    /**
     * Verifica se o metodo EventListItemAction->update(data: $data, updatedBy: $updatedBy) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_update_is_correct(): void
    {
        $data = [
            'id' => fake()->randomNumber(1,9999),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'event_id' => fake()->randomNumber(1,9999),
            'event_list_id' => fake()->randomNumber(1,9999),
            'payment_status' => EventListItemPaymentStatusEnum::PAID->value,
            'saas_client_id' => fake()->randomNumber(1,9999),
            'updated_by' => fake()->randomNumber(1,9999),
        ];

        $modelMockedExpected = $this->createPartialMock(originalClassName: EventListItem::class, methods: ['fill', 'setAttribute']);
        $modelMockedExpected->id = $data['id'];
        $modelMockedExpected->name = $data['name'];
        $modelMockedExpected->email = $data['email'];
        $modelMockedExpected->phone = $data['phone'];
        $modelMockedExpected->event_id = $data['event_id'];
        $modelMockedExpected->event_list_id = $data['event_list_id'];
        $modelMockedExpected->payment_status = $data['payment_status'];
        $modelMockedExpected->saas_client_id = $data['saas_client_id'];

        $repositoryMocked = Mockery::mock(args: EventListItemRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'update')->with((int) $data['id'], (array) $data)->andReturn(args: $modelMockedExpected);

        $actionToTest = new EventListItemAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->update((int) $data['id'], (array) $data);

        $this->assertEquals(expected: $modelMockedExpected->toArray(), actual: $actualValue->toArray(), message: 'O retorno do metodo update do action não está correto.');
    }

    /**
     * Verifica se o metodo EventListItemAction->delete(id: $id, deletedBy: $deletedBy) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_delete_is_correct(): void
    {
        $idToDelete = fake()->randomNumber(1,9999);
        $deletedBy = fake()->randomNumber(1,9999);

        $repositoryMocked = Mockery::mock(args: EventListItemRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'delete')->with($idToDelete, $deletedBy)->andReturnTrue();

        $actionToTest = new EventListItemAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->delete($idToDelete, $deletedBy);

        $this->assertTrue(condition: $actualValue, message: 'O retorno do metodo delete do action não está correto.');
    }
}
