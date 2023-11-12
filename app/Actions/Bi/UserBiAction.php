<?php

namespace App\Actions\Bi;

use App\Contracts\{
    Actions\Bi\UserBiActionInterface,
    Repositories\Bi\UserBiRepositoryInterface,
};

/**
 * Classe Action para camada de negócio para entidade Usuário (users/User)
 */
class UserBiAction implements UserBiActionInterface {

    public function __construct(
        private UserBiRepositoryInterface $repository
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

    /**
     * Obtem o total de registros
     *
     * @return int|mixed
     */
    function getTotal() {
        return $this->repository->getTotal();
    }

    /**
     * Obtem o total de registros criados hoje
     *
     * @return int|mixed
     */
    function getTotalRegisteredToday() {
        return $this->repository->getTotalRegisteredToday();
    }

    /**
     * Obtem o total de registros criados essa semana
     *
     * @return int|mixed
     */
    function getTotalRegisteredThisWeek() {
        return $this->repository->getTotalRegisteredThisWeek();
    }

    /**
     * Obtem o total de registros criados este mes
     *
     * @return int|mixed
     */
    function getTotalRegisteredThisMonth() {
        return $this->repository->getTotalRegisteredThisMonth();
    }

    /**
     * Obtem o total de registros deletados até o momento
     *
     * @return int|mixed
     */
    function getTotalDeleted() {
        return $this->repository->getTotalDeleted();
    }

    /**
     * Obtem o total de registros deletados até o momento
     *
     * @return int|mixed
     */
    function getTotalByCreated() {
        return $this->repository->getTotalByCreated();
    }

}
