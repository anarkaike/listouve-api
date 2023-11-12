<?php

namespace Tests\Unit\Actions;

use App\Actions\UserAction;
use App\Enums\User\UserStatusEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserActionTest extends TestCase
{

    /**
     * Verifica se o metodo UserRepository->listAll() retorna o valor correto
     * @test
     */
    public function check_if_return_list_all_is_correct(): void
    {
        $expectedValue = ['1', '2', '3'];

        $repositoryMocked = Mockery::mock(args: UserRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'listAll')->andReturn(args: $expectedValue);


        $actionToTest = new UserAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->listAll();
        $arrayDiff = array_diff($expectedValue, $actualValue);

        $this->assertEquals(expected: 0, actual: count($arrayDiff), message: 'O retorno do metodo listAll do action não está correto.');
    }

    /**
     * Verifica se o metodo UserAction->findById(id: $id) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_find_by_id_is_correct(): void
    {
        $idToFind = fake()->randomNumber(1,9999);

        $userMockedExpected = $this->createPartialMock(originalClassName: User::class, methods: ['fill', 'setAttribute']);
        $userMockedExpected->id = $idToFind;
        $userMockedExpected->name = fake()->name();
        $userMockedExpected->email = fake()->email();
        $userMockedExpected->password = fake()->password();
        $userMockedExpected->phone_personal = fake()->phoneNumber();
        $userMockedExpected->phone_professional = fake()->phoneNumber();
        $userMockedExpected->url_photo = fake()->imageUrl();
        $userMockedExpected->status = UserStatusEnum::ACTIVE->value;

        $modelMocked = Mockery::mock(args: UserRepository::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'findById')->with($idToFind)->andReturn(args: $userMockedExpected);

        $actionToTest = new UserAction(repository: $modelMocked);
        $actualValue = $actionToTest->findById(id: $idToFind);

        $this->assertEquals(expected: $userMockedExpected->toArray(), actual: $actualValue->toArray(), message: 'O retorno do metodo findById do action não está correto.');
    }

    /**
     * Verifica se o metodo UserAction->create(data: $data) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_create_is_correct(): void
    {
        $data = [
            'id' => fake()->randomNumber(1,9999),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => fake()->password(),
            'phone_personal' => fake()->phoneNumber(),
            'phone_professional' => fake()->phoneNumber(),
            'url_photo' => fake()->imageUrl(),
            'status' => UserStatusEnum::ACTIVE->value,
            'created_by' => fake()->randomNumber(1,9999),
        ];

        $userMockedExpected = $this->createPartialMock(originalClassName: User::class, methods: ['fill', 'setAttribute']);
        $userMockedExpected->id = $data['id'];
        $userMockedExpected->name = $data['name'];
        $userMockedExpected->email = $data['email'];
        $userMockedExpected->password = $data['password'];
        $userMockedExpected->phone_personal = $data['phone_personal'];
        $userMockedExpected->phone_professional = $data['phone_professional'];
        $userMockedExpected->url_photo = $data['url_photo'];
        $userMockedExpected->status = $data['status'];
        $userMockedExpected->created_by = $data['created_by'];

        $repositoryMocked = Mockery::mock(args: UserRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'create')->with($data)->andReturn(args: $userMockedExpected);

        $actionToTest = new UserAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->create($data);

        $this->assertEquals(expected: $userMockedExpected->toArray(), actual: $actualValue->toArray(), message: 'O retorno do metodo create do action não está correto.');
    }

    /**
     * Verifica se o metodo UserAction->create(data: $data) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_update_is_correct(): void
    {
        $data = [
            'id' => fake()->randomNumber(1,9999),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => fake()->password(),
            'phone_personal' => fake()->phoneNumber(),
            'phone_professional' => fake()->phoneNumber(),
            'url_photo' => fake()->imageUrl(),
            'status' => UserStatusEnum::ACTIVE->value,
            'updated_by' => fake()->randomNumber(1,9999),
        ];

        $userMockedExpected = $this->createPartialMock(originalClassName: User::class, methods: ['fill', 'setAttribute']);
        $userMockedExpected->id = $data['id'];
        $userMockedExpected->name = $data['name'];
        $userMockedExpected->email = $data['email'];
        $userMockedExpected->password = $data['password'];
        $userMockedExpected->phone_personal = $data['phone_personal'];
        $userMockedExpected->phone_professional = $data['phone_professional'];
        $userMockedExpected->url_photo = $data['url_photo'];
        $userMockedExpected->status = $data['status'];
        $userMockedExpected->updated_by = $data['updated_by'];

        $repositoryMocked = Mockery::mock(args: UserRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'update')->with((int) $data['id'], (array) $data)->andReturn(args: $userMockedExpected);

        $actionToTest = new UserAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->update((int) $data['id'], (array) $data);

        $this->assertEquals(expected: $userMockedExpected->toArray(), actual: $actualValue->toArray(), message: 'O retorno do metodo update do action não está correto.');
    }

    /**
     * Verifica se o metodo UserAction->create(data: $data) retorna o valor correto
     * @test
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function check_if_return_delete_is_correct(): void
    {
        $idToDelete = fake()->randomNumber(1,9999);
        $deletedBy = fake()->randomNumber(1,9999);

        $repositoryMocked = Mockery::mock(args: UserRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'delete')->with($idToDelete, $deletedBy)->andReturnTrue();

        $actionToTest = new UserAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->delete($idToDelete, $deletedBy);

        $this->assertTrue(condition: $actualValue, message: 'O retorno do metodo delete do action não está correto.');
    }
}
