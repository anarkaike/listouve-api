<?php

namespace App\Contracts\Actions\Bi;

/**
 * Interface generica para padronizar metodos dos Actions (classe que faz queries eloquent)
 */
interface BiActionInterface
{
    /**
     * Obtem todos os dados de BI
     *
     * @return mixed
     */
    public function all();

    /**
     * Obtem o total geral
     *
     * @return mixed
     */
    function getTotal();

    /**
     * Obtem o total de registros feito hoje
     *
     * @return mixed
     */
    function getTotalRegisteredToday();

    /**
     * Obtem o total de registros feito essa semana
     * @return mixed
     */
    function getTotalRegisteredThisWeek();

    /**
     * Obtem ototal de registros feito esse mes
     * @return mixed
     */
    function getTotalRegisteredThisMonth();

    /**
     * Obtem o total de registros deletados até o momento
     *
     * @return mixed
     */
    function getTotalDeleted();
}
