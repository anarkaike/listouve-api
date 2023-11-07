<?php

namespace App\Actions\Bi;

use App\Contracts\{
    Actions\Bi\SaasClientBiActionInterface,
    Repositories\Bi\SaasClientBiRepositoryInterface,
};

/**
 * Classe Action para camada de negócio para entidade Clientes Saas (saas_clients/SaasClients)
 */
class SaasClientBiAction implements SaasClientBiActionInterface {

    public function __construct(
        private SaasClientBiRepositoryInterface $saasClientBiRepository
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
        return $this->saasClientBiRepository->getTotal();
    }

    /**
     * Obtem o total de registros criados hoje
     *
     * @return int|mixed
     */
    function getTotalRegisteredToday() {
        return $this->saasClientBiRepository->getTotalRegisteredToday();
    }

    /**
     * Obtem o total de registros criados essa semana
     *
     * @return int|mixed
     */
    function getTotalRegisteredThisWeek() {
        return $this->saasClientBiRepository->getTotalRegisteredThisWeek();
    }

    /**
     * Obtem o total de registros criados este mes
     *
     * @return int|mixed
     */
    function getTotalRegisteredThisMonth() {
        return $this->saasClientBiRepository->getTotalRegisteredThisMonth();
    }

    /**
     * Obtem o total de registros deletados até o momento
     *
     * @return int|mixed
     */
    function getTotalDeleted() {
        return $this->saasClientBiRepository->getTotalDeleted();
    }

    /**
     * Obtem o total de registros deletados até o momento
     *
     * @return int|mixed
     */
    function getTotalByCreated() {
        return $this->saasClientBiRepository->getTotalByCreated();
    }

}
