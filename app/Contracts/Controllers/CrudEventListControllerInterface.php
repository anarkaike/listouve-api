<?php

namespace App\Contracts\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{
    EventList\EventListCreateRequest,
    EventList\EventListDeleteRequest,
    EventList\EventListUpdateRequest,
};

/**
 * Interface para padrinizar os metodos CRUD no controller
 */
interface CrudEventListControllerInterface
{
    /**
     * Obtem todos os registros
     *
     * @param Request $request
     * @return mixed
     */
    public function listAll(Request $request);

    /**
     * Busca um único registro pelo ID
     *
     * @param Request $request
     * @return mixed
     */
    public function findById(Request $request);

    /**
     * Cria um novo registro
     *
     * @param EventListCreateRequest $request
     * @return mixed
     */
    public function create(EventListCreateRequest $request);

    /**
     * Atualiza um registro
     *
     * @param EventListCreateRequest $request
     * @return mixed
     */
    public function update(EventListUpdateRequest $request);

    /**
     * Deleta um registro
     *
     * @param EventListCreateRequest $request
     * @return mixed
     */
    public function delete(EventListDeleteRequest $request);
}
