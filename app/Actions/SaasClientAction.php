<?php

namespace App\Actions;

use App\Contracts\Actions\SaasClientActionInterface;
use App\Contracts\Repositories\SaasClientRepositoryInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Classe Action para camada de negócio para entidade Eventos (saas_clients|SaasClient)
 */
class SaasClientAction implements SaasClientActionInterface {

    public function __construct(
        private SaasClientRepositoryInterface $saasClientRepository
    )
    {

    }

    public function listAll()
    {
        return $this->saasClientRepository->listAll();
    }

    public function findById(int $id)
    {
        return $this->saasClientRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        return $this->saasClientRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $data['updated_by'] = Auth::id();
        return $this->saasClientRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->saasClientRepository->delete(id: $id, deletedBy: Auth::id());
    }
}
