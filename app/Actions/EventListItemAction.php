<?php

namespace App\Actions;

use App\Contracts\Actions\EventListItemActionInterface;
use App\Contracts\Repositories\EventListItemRepositoryInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Classe Action para camada de negócio para entidade Listas de Eventos (events_lists|EventList)
 */
class EventListItemAction implements EventListItemActionInterface {

    public function __construct(
        private EventListItemRepositoryInterface $eventListItemRepository
    )
    {

    }

    public function listAll()
    {
        return $this->eventListItemRepository->listAll();
    }

    public function findById(int $id)
    {
        return $this->eventListItemRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        return $this->eventListItemRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $data['updated_by'] = Auth::id();
        return $this->eventListItemRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->eventListItemRepository->delete(id: $id, deletedBy: Auth::id());
    }
}
