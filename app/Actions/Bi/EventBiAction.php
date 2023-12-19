<?php

namespace App\Actions\Bi;

use App\Contracts\{
    Actions\Bi\EventBiActionInterface,
    Repositories\Bi\EventBiRepositoryInterface,
};

class EventBiAction implements EventBiActionInterface {

    public function __construct(
        private EventBiRepositoryInterface $repository
    )
    {
    }

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

    function getTotal() {
        return $this->repository->getTotal();
    }

    function getTotalRegisteredToday() {
        return $this->repository->getTotalRegisteredToday();
    }

    function getTotalRegisteredThisWeek() {
        return $this->repository->getTotalRegisteredThisWeek();
    }

    function getTotalRegisteredThisMonth() {
        return $this->repository->getTotalRegisteredThisMonth();
    }

    function getTotalDeleted() {
        return $this->repository->getTotalDeleted();
    }

    function getTotalByCreated() {
        return $this->repository->getTotalByCreated();
    }

}
