<?php

namespace App\Actions;

use App\Contracts\Actions\EventActionInterface;
use App\Contracts\Repositories\EventRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class EventAction implements EventActionInterface {

    public function __construct(
        private EventRepositoryInterface $eventRepository
    )
    {

    }

    public function listAll()
    {
        return $this->eventRepository->listAll();
    }

    public function findById(int $id)
    {
        return $this->eventRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        return $this->eventRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $data['updated_by'] = Auth::id();
        return $this->eventRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $data['deleted_by'] = Auth::id();
        return $this->eventRepository->delete($id);
    }
}
