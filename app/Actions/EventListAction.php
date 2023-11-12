<?php

namespace App\Actions;

use App\Contracts\Actions\EventListActionInterface;
use App\Contracts\Repositories\EventListRepositoryInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Classe Action para camada de negócio para entidade Listas de Eventos (events|Event)
 */
class EventListAction implements EventListActionInterface {

    public function __construct(
        private EventListRepositoryInterface $repository
    )
    {

    }

    public function listAll()
    {
        return $this->repository->listAll();
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = $data['created_by'] ?? Auth::id();
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $data['updated_by'] = $data['updated_by'] ?? Auth::id();
        return $this->repository->update($id, $data);
    }

    public function delete(int $id, int $deletedBy = null): bool
    {
        return $this->repository->delete(id: $id, deletedBy: $deletedBy ?? Auth::id());
    }
}
