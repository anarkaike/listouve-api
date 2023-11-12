<?php

namespace Tests\Unit\Actions\Bi;

use App\Actions\Bi\EventBiAction;
use App\Enums\Event\EventStatusEnum;
use App\Models\Event;
use App\Repositories\Bi\EventBiRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class EventBiActionTest extends TestCase
{

    /**
     * Verifica se o metodo EventBiAction->getTotal() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_is_correct(): void
    {
        $expectedValue = 10;

        $repositoryMocked = Mockery::mock(args: EventBiRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'getTotal')->andReturn(args: $expectedValue);


        $actionToTest = new EventBiAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->getTotal();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'O retorno do metodo getTotal do action não está correto.');
    }

    /**
     * Verifica se o metodo EventBiAction->getTotal() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_registered_today_is_correct(): void
    {
        $expectedValue = 10;

        $repositoryMocked = Mockery::mock(args: EventBiRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'getTotalRegisteredToday')->andReturn(args: $expectedValue);


        $actionToTest = new EventBiAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->getTotalRegisteredToday();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'O retorno do metodo getTotalRegisteredToday do action não está correto.');
    }

    /**
     * Verifica se o metodo EventBiAction->getTotal() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_registered_this_week_is_correct(): void
    {
        $expectedValue = 10;

        $repositoryMocked = Mockery::mock(args: EventBiRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'getTotalRegisteredThisWeek')->andReturn(args: $expectedValue);


        $actionToTest = new EventBiAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->getTotalRegisteredThisWeek();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'O retorno do metodo getTotalRegisteredThisWeek do action não está correto.');
    }

    /**
     * Verifica se o metodo EventBiAction->getTotal() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_registered_this_month_is_correct(): void
    {
        $expectedValue = 10;

        $repositoryMocked = Mockery::mock(args: EventBiRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'getTotalRegisteredThisMonth')->andReturn(args: $expectedValue);


        $actionToTest = new EventBiAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->getTotalRegisteredThisMonth();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'O retorno do metodo getTotalRegisteredThisMonth do action não está correto.');
    }

    /**
     * Verifica se o metodo EventBiAction->getTotal() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_deleted_is_correct(): void
    {
        $expectedValue = 10;

        $repositoryMocked = Mockery::mock(args: EventBiRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'getTotalDeleted')->andReturn(args: $expectedValue);


        $actionToTest = new EventBiAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->getTotalDeleted();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'O retorno do metodo getTotalDeleted do action não está correto.');
    }

    /**
     * Verifica se o metodo EventBiAction->getTotal() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_by_created_is_correct(): void
    {
        $expectedValue = [
            ['period' => '10/11','total' => 10],
            ['period' => '11/11','total' => 20],
        ];

        $repositoryMocked = Mockery::mock(args: EventBiRepository::class)->makePartial();
        $repositoryMocked->shouldReceive(methodNames: 'getTotalByCreated')->andReturn(args: $expectedValue);


        $actionToTest = new EventBiAction(repository: $repositoryMocked);
        $actualValue = $actionToTest->getTotalByCreated();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'O retorno do metodo getTotalByCreated do action não está correto.');
    }
}
