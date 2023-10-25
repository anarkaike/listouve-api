<?php
namespace App\Repositories;

use App\Contracts\Repositories\EventListItemRepositoryInterface;
use App\Models\EventListItem;

/**
 * Repositório de EventListItemo, camada que chama o eloquent
 * para interagir com banco de dados, usando eloquent
 *
 * Camada para chamar Eloquent e iteragir com banco de dados.
 * Aqui não tem regras de negócio. Elas ficam nos actins.
 * Os actions e repositories são chamados onde for necessário, ex.: controllers
 */
class EventListItemRepository implements EventListItemRepositoryInterface
{
    protected $eventListItem;

    /**
     * Recebemos o model do eloquent para iteragir com banco de dados.
     *
     * @param EventListItem $eventListItem
     */
    public function __construct(EventListItem $eventListItem)
    {
        $this->eventListItem = $eventListItem;
    }

    /**
     * Retorna todos os registros
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listAll()
    {
        return $this->eventListItem->all();
    }

    /**
     * Busca um registro pelo ID
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->eventListItem->find($id);
    }

    /**
     * Cria um registro novo
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->eventListItem->create($data);
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
        $eventListItem = $this->eventListItem->find($id);

        if ($eventListItem) {
            $eventListItem->update($data);
            return $eventListItem;
        }

        return null;
    }

    /**
     * Deleta um registro
     *
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $eventListItem = $this->eventListItem->find($id);

        if ($eventListItem) {
            $eventListItem->delete();
            return true;
        }

        return false;
    }
}
