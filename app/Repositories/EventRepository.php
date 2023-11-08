<?php
namespace App\Repositories;

use App\Contracts\Repositories\EventRepositoryInterface;
use App\Models\Event;

/**
 * Repositório de evento, camada que chama o eloquent
 * para interagir com banco de dados, usando eloquent
 *
 * Camada para chamar Eloquent e iteragir com banco de dados.
 * Aqui não tem regras de negócio. Elas ficam nos actins.
 * Os actions e repositories são chamados onde for necessário, ex.: controllers
 */
class EventRepository implements EventRepositoryInterface
{
    /**
     * Injtetamos o model Event
     *
     * @param Event $event
     */
    public function __construct(
        protected Event $event
    )
    {
    }

    /**
     * Retorna todos os registros
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listAll()
    {
        return $this->event->filter()->get();
    }

    /**
     * Busca um registro pelo ID
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->event->find($id);
    }

    /**
     * Cria um registro novo
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->event->create($data);
    }

    /**
     * Atualiza um registro
     *
     * @param $id
     * @param array $data
     * @return null
     */
    public function update($id, array $data)
    {
        $event = $this->event->find($id);

        if ($event) {
            $event->update($data);
            return $event;
        }

        return null;
    }

    /**
     * Deleta um registro
     *
     * @param $id
     * @param null $deletedBy
     * @return bool
     */
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
