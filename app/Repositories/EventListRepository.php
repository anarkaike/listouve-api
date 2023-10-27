<?php
namespace App\Repositories;

use App\Contracts\Repositories\EventListRepositoryInterface;
use App\Models\EventList;

/**
 * Repositório de EventListo, camada que chama o eloquent
 * para interagir com banco de dados, usando eloquent
 *
 * Camada para chamar Eloquent e iteragir com banco de dados.
 * Aqui não tem regras de negócio. Elas ficam nos actins.
 * Os actions e repositories são chamados onde for necessário, ex.: controllers
 */
class EventListRepository implements EventListRepositoryInterface
{
    protected $eventList;

    /**
     * Recebemos o model do eloquent para iteragir com banco de dados.
     *
     * @param EventList $eventList
     */
    public function __construct(EventList $eventList)
    {
        $this->eventList = $eventList;
    }

    /**
     * Retorna todos os registros
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listAll()
    {
        return $this->eventList->all();
    }

    /**
     * Busca um registro pelo ID
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->eventList->find($id);
    }

    /**
     * Cria um registro novo
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $data['id'] = 1;
        $data['created_by'] = $data['updated_by'] = $data['deleted_by'] = 1;
        return $this->eventList->create($data);
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
        $eventList = $this->eventList->find($id);

        if ($eventList) {
            $eventList->update($data);
            return $eventList;
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
        $eventList = $this->eventList->find($id);

        if ($eventList) {
            $eventList->delete();
            return true;
        }

        return false;
    }
}
