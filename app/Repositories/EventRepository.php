<?php
namespace App\Repositories;

use App\Contracts\Repositories\EventRepositoryInterface;
use App\Models\Event;


class EventRepository implements EventRepositoryInterface
{
    public function __construct(
        protected Event $event
    )
    {
    }

    public function listAll()
    {
        return $this->event->filter()->get();
    }

    public function findById($id)
    {
        return $this->event->find($id);
    }

    public function create(array $data)
    {
        return $this->event->create($data);
    }

    public function update($id, array $data)
    {
        $event = $this->event->find($id);

        if ($event) {
            $event->update($data);
            return $event;
        }

        return null;
    }

    public function delete($id, $deletedBy = null): bool
    {
        $event = $this->event->find($id);

        if ($event) {
            $event->delete();
            return true;
        }

        return false;
    }
}
