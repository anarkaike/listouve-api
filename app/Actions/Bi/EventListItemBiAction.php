<?php

namespace App\Actions\Bi;

use App\Contracts\{
    Actions\Bi\EventListItemBiActionInterface,
    Repositories\Bi\EventListItemBiRepositoryInterface,
};

/**
 * Classe Action para camada de negócio para Nomes das listas de eventos (events_lists_items/EventListItem)
 */
class EventListItemBiAction implements EventListItemBiActionInterface {

    public function __construct(
        private EventListItemBiRepositoryInterface $eventListItemBiRepository
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
            'total_by_created' => $this->getTotalByCreated(),
        ];
    }

    /**
     * Obtem o total de registros
     *
     * @return int|mixed
     */
    function getTotal() {
        return $this->eventListItemBiRepository->getTotal();
    }

    /**
     * Obtem o total de registros criados hoje
     *
     * @return int|mixed
     */
    function getTotalRegisteredToday() {
        return $this->eventListItemBiRepository->getTotalRegisteredToday();
    }

    /**
     * Obtem o total de registros criados essa semana
     *
     * @return int|mixed
     */
    function getTotalRegisteredThisWeek() {
        return $this->eventListItemBiRepository->getTotalRegisteredThisWeek();
    }

    /**
     * Obtem o total de registros criados este mes
     *
     * @return int|mixed
     */
    function getTotalRegisteredThisMonth() {
        return $this->eventListItemBiRepository->getTotalRegisteredThisMonth();
    }

    /**
     * Obtem o total de registros deletados até o momento
     *
     * @return int|mixed
     */
    function getTotalDeleted() {
        return $this->eventListItemBiRepository->getTotalDeleted();
    }

    /**
     * Obtem o total de registros deletados até o momento
     *
     * @return int|mixed
     */
    function getTotalByCreated() {
        return $this->eventListItemBiRepository->getTotalByCreated();
    }
}
