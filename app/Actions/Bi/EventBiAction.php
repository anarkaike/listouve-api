<?php

namespace App\Actions\Bi;

use App\Contracts\{
    Actions\Bi\EventBiActionInterface,
    Repositories\Bi\EventBiRepositoryInterface,
};

/**
 * Classe Action para camada de negócio para Eventos (events/Event)
 */
class EventBiAction implements EventBiActionInterface {

    public function __construct(
        private EventBiRepositoryInterface $eventBiRepository
    )
    {
    }

    /**
     * Obtem todas as estatisticas dessa classe
     *
     * @return array|int[]
     */
    public function all()
    {
        return [
            'total' => $this->getTotal(),
            'total_deleted' => $this->getTotalDeleted(),
            'total_registered_today' => $this->getTotalRegisteredToday(),
            'total_registered_this_week' => $this->getTotalRegisteredThisWeek(),
            'total_registered_this_month' => $this->getTotalRegisteredThisMonth(),
        ];
    }

    /**
     * Obtem o total de registros
     *
     * @return int|mixed
     */
    function getTotal() {
        return $this->eventBiRepository->getTotal();
    }

    /**
     * Obtem o total de registros criados hoje
     *
     * @return int|mixed
     */
    function getTotalRegisteredToday() {
        return $this->eventBiRepository->getTotalRegisteredToday();
    }

    /**
     * Obtem o total de registros criados essa semana
     *
     * @return int|mixed
     */
    function getTotalRegisteredThisWeek() {
        return $this->eventBiRepository->getTotalRegisteredThisWeek();
    }

    /**
     * Obtem o total de registros criados este mes
     *
     * @return int|mixed
     */
    function getTotalRegisteredThisMonth() {
        return $this->eventBiRepository->getTotalRegisteredThisMonth();
    }

    /**
     * Obtem o total de registros deletados até o momento
     *
     * @return int|mixed
     */
    function getTotalDeleted() {
        return $this->eventBiRepository->getTotalDeleted();
    }

}
