<?php

namespace App\Contracts\Repositories\Bi;

/**
 * Interface generica para padronizar metodos dos Repositorys (classe que faz queries eloquent)
 */
interface BiRepositoryInterface
{
    /**
     * Obtem todos os dados de BI
     *
     * @return array
     */
    public function all(): array;

    /**
     * Obtem o total geral
     *
     * @return int
     */
    function getTotal(): int;

    /**
     * Obtem o total de registros feito hoje
     *
     * @return int
     */
    function getTotalRegisteredToday(): int;

    /**
     * Obtem o total de registros feito essa semana
     * @return int
     */
    function getTotalRegisteredThisWeek(): int;

    /**
     * Obtem ototal de registros feito esse mes
     * @return int
     */
    function getTotalRegisteredThisMonth(): int;

    /**
     * Obtem o total de registros deletados até o momento
     *
     * @return int
     */
    function getTotalDeleted(): int;
}
