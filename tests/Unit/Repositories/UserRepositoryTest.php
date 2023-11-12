<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\{
    Enums\User\UserStatusEnum,
    Models\User,
    Repositories\UserRepository,
};

class UserRepositoryTest extends TestCase
{
    /**
     * Verifica se o metodo UserRepository->listAll() retorna o valor correto
     * @test
     */
    public function check_if_return_list_all_is_correct(): void
    {
        $expectedValue = ['1', '2', '3'];

        $modelMocked = Mockery::mock(args: User::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'filter')->andReturnSelf();
        $modelMocked->shouldReceive(methodNames: 'get')->andReturn(args: $expectedValue);


        $repositoryToTest = new UserRepository(user: $modelMocked);
        $actualValue = $repositoryToTest->listAll();
        $arrayDiff = array_diff($expectedValue, $actualValue);

        $this->assertEquals(expected: 0, actual: count($arrayDiff), message: 'O retorno do metodo listAll do repository não está correto.');
    }

    /**
     * Verifica se o metodo UserRepository->findById(id: $id) retorna o valor correto
     * @test
     */
    public function check_if_return_find_by_id_is_correct(): void
    {
        $expectedValue = ['id' => 1, 'name' => fake()->name()];

        $modelMocked = Mockery::mock(args: User::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'find')->with($expectedValue['id'])->andReturn($expectedValue);


        $repositoryToTest = new UserRepository(user: $modelMocked);
        $actualValue = $repositoryToTest->findById(id: 1);
        $arrayDiff = array_diff($expectedValue, $actualValue);

        $this->assertEquals(expected: 0, actual: count($arrayDiff), message: 'O retorno do metodo findById do repository não está correto.');
    }

    /**
     * Verifica se o metodo UserRepository->create() retorna o valor correto
     * @test
     */
    public function check_if_return_create_is_correct(): void
    {
        $expectedValue = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => fake()->randomLetter(),
            'phone_personal' => fake()->phoneNumber(),
            'phone_professional' => fake()->phoneNumber(),
            'url_photo' => fake()->imageUrl(),
            'status' => UserStatusEnum::ACTIVE->value,
        ];

        $modelMocked = Mockery::mock(args: User::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'create')->with($expectedValue)->andReturn(args: $expectedValue);


        $repositoryToTest = new UserRepository(user: $modelMocked);
        $actualValue = $repositoryToTest->create(data: $expectedValue);
        $arrayDiff = array_diff($expectedValue, $actualValue);

        $this->assertEquals(expected: 0, actual: count(value: $arrayDiff), message: 'O retorno do metodo create do repository não está correto.');
    }

    /**
     * Verifica se o metodo UserRepository->update() retorna o valor correto
     * @test
     */
    public function check_if_return_update_is_correct(): void
    {
        $expectedValue = [
            'id' => fake()->numberBetween(int1: 1, int2: 999),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => fake()->randomLetter(),
            'phone_personal' => fake()->phoneNumber(),
            'phone_professional' => fake()->phoneNumber(),
            'url_photo' => fake()->imageUrl(),
            'status' => UserStatusEnum::ACTIVE->value,
        ];

        $modelMocked = Mockery::mock(args: User::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'find')->with($expectedValue['id'])->andReturnSelf();
        $modelMocked->shouldReceive(methodNames: 'update')->with($expectedValue)->andReturn(args: $expectedValue);

        $repositoryToTest = new UserRepository(user: $modelMocked);

        $actualValue = $repositoryToTest->update(id: $expectedValue['id'], data: $expectedValue);
        $this->assertEquals(expected: $modelMocked, actual: $actualValue, message: 'Retorno do metodo update do repository não está correto.');
    }

    /**
     * Verifica se o metodo UserRepository->delete() retorna o valor correto
     * @test
     */
    public function check_if_return_delete_is_correct(): void
    {
        $id = 1;
        $deletedBy = 1;

        $modelMocked = Mockery::mock(args: User::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'find')->with($id)->andReturnSelf();
        $modelMocked->shouldReceive(methodNames: 'update')->andReturnTrue();
        $modelMocked->shouldReceive(methodNames: 'delete')->andReturnTrue();

        $repositoryToTest = new UserRepository(user: $modelMocked);

        $actualValue = $repositoryToTest->delete(id: $id, deletedBy: $deletedBy);
        $this->assertTrue(condition: $actualValue, message: 'O retorno do metodo delete do repository não está correto.');
    }
}
