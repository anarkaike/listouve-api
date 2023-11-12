<?php

namespace Tests\Unit\Repositories\Bi;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\{
    Models\EventListItem,
    Repositories\Bi\EventListItemBiRepository,
};

class EventListItemBiRepositoryTest extends TestCase
{
    /**
     * Verifica se o metodo EventListItemBiRepository->getTotal() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_is_correct(): void
    {
        $expectedValue = 5;

        $modelMocked = Mockery::mock(args: EventListItem::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'all')->andReturnSelf();
        $modelMocked->shouldReceive(methodNames: 'count')->andReturn(args: $expectedValue);


        $repositoryToTest = new EventListItemBiRepository(eventListItem: $modelMocked);
        $actualActual = $repositoryToTest->getTotal();

        $this->assertEquals(expected: $expectedValue, actual: $actualActual, message: 'O retorno do metodo do repository não está correto.');
    }

    /**
     * Verifica se o metodo EventListItemBiRepository->getTotalRegisteredToday() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_registered_today_is_correct(): void
    {
        $expectedValue = 5;

        $modelMocked = Mockery::mock(args: EventListItem::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'whereDate')->andReturnSelf();
        $modelMocked->shouldReceive(methodNames: 'count')->andReturn(args: $expectedValue);


        $repositoryToTest = new EventListItemBiRepository(eventListItem: $modelMocked);
        $actualActual = $repositoryToTest->getTotalRegisteredToday();

        $this->assertEquals(expected: $expectedValue, actual: $actualActual, message: 'O retorno do metodo do repository não está correto.');
    }

    /**
     * Verifica se o metodo EventListItemRepository->getTotalRgisteredThisWeek() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_registered_this_week_is_correct(): void
    {
        $expectedValue = 5;

        $modelMocked = Mockery::mock(args: EventListItem::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'whereBetween')->andReturnSelf();
        $modelMocked->shouldReceive(methodNames: 'count')->andReturn(args: $expectedValue);


        $repositoryToTest = new EventListItemBiRepository(eventListItem: $modelMocked);
        $actualActual = $repositoryToTest->getTotalRegisteredThisWeek();

        $this->assertEquals(expected: $expectedValue, actual: $actualActual, message: 'O retorno do metodo do repository não está correto.');
    }

    /**
     * Verifica se o metodo EventListItemRepository->getTotal() retorna o valor correto
     * @test
     */
    public function check_if_return_get_total_registered_this_mouth_is_correct(): void
    {
        $expectedValue = 5;

        $modelMocked = Mockery::mock(args: EventListItem::class)->makePartial();
        $modelMocked->shouldReceive(methodNames: 'whereBetween')->andReturnSelf();
        $modelMocked->shouldReceive(methodNames: 'count')->andReturn(args: $expectedValue);


        $repositoryToTest = new EventListItemBiRepository(eventListItem: $modelMocked);
        $actualActual = $repositoryToTest->getTotalRegisteredThisMonth();

        $this->assertEquals(expected: $expectedValue, actual: $actualActual, message: 'O retorno do metodo do repository não está correto.');
    }

    /**
     * Verifica se o metodo EventListItemRepository->getTotal() retorna o valor correto
     * @test
     */
//    public function check_if_return_get_total_deleted_is_correct(): void
//    {
        // Não consegui fazer funcionar por causa da DB::raw
//        $expectedValue = [
//            ['date' => '10/11', 'total' => 2],
//            ['date' => '11/11', 'total' => 5],
//            ['date' => '12/11', 'total' => 7],
//        ];
//
//        $modelMocked = Mockery::mock(args: EventListItem::class)->makePartial();
//        $modelMocked->shouldReceive(methodNames: 'select')->andReturnSelf();
//        $modelMocked->shouldReceive(methodNames: 'groupBy')->andReturnSelf();
//        $modelMocked->shouldReceive(methodNames: 'orderBy')->andReturnSelf();
//        $modelMocked->shouldReceive(methodNames: 'get')->andReturnSelf();
//        $modelMocked->shouldReceive(methodNames: 'toArray')->andReturn(args: $expectedValue);
//
//        $DB = Mockery::mock(args: DB::class)->makePartial();
//        $DB->expects($this->once())->shouldReceive(methodNames: 'raw')->andReturn('DATE_FORMAT(created_at, "%d/%m") as date');
//        $DB->expects($this->once())->shouldReceive(methodNames: 'raw')->andReturn('COUNT(*) as total');
//        $DB->expects($this->once())->shouldReceive(methodNames: 'raw')->andReturn('DATE_FORMAT(created_at, "%d/%m")');
//        $DB->expects($this->once())->shouldReceive(methodNames: 'raw')->andReturn('DATE_FORMAT(created_at, "%d/%m")');
//
//
//        $repositoryToTest = new EventListItemBiRepository(eventListItem: $modelMocked);
//        $actualActual = $repositoryToTest->getTotalByCreated();
//
//        $this->assertEquals(expected: $expectedValue, actual: $actualActual, message: 'O retorno do metodo do repository não está correto.');
//    }

}
