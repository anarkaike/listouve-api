<?php

namespace App\Actions;

use App\Contracts\Actions\EventActionInterface;
use App\Contracts\Repositories\EventRepositoryInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Classe Action para camada de negócio para entidade Eventos (events|Event)
 */
class EventAction implements EventActionInterface {

    public function __construct(
        private EventRepositoryInterface $repository
    )
    {

    }

    /**
     * Lista todos os eventos
     *
     * @return mixed
     */
    public function listAll()
    {
        return $this->repository->listAll();
    }

    /**
     * Obtem um evento pelo ID
     *
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    /**
     * Cria um evento
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $data['created_by'] = $data['created_by'] ?? Auth::id();
        return $this->repository->create($data);
    }

    /**
     * Atualiza um evento
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $data['updated_by'] = $data['updated_by'] ?? Auth::id();
        return $this->repository->update($id, $data);
    }

    /**
     * Deleta um evento
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id, int $deletedBy = null): bool
    {
        return $this->repository->delete(id: $id, deletedBy: $deletedBy ?? Auth::id());
    }
}
