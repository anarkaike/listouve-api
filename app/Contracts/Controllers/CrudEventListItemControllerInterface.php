<?php

namespace App\Contracts\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{
    EventListItem\EventListItemCreateRequest,
    EventListItem\EventListItemDeleteRequest,
    EventListItem\EventListItemUpdateRequest,
};

/**
 * Interface para padrinizar os metodos CRUD no controller
 */
interface CrudEventListItemControllerInterface
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
     * @param EventListItemCreateRequest $request
     * @return mixed
     */
    public function create(EventListItemCreateRequest $request);

    /**
     * Atualiza um registro
     *
     * @param EventListItemCreateRequest $request
     * @return mixed
     */
    public function update(EventListItemUpdateRequest $request);

    /**
     * Deleta um registro
     *
     * @param EventListItemCreateRequest $request
     * @return mixed
     */
    public function delete(EventListItemDeleteRequest $request);
}
