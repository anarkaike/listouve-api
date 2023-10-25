<?php

namespace App\Contracts\Controllers;

use App\Http\Requests\{Event\EventCreateRequest, Event\EventDeleteRequest, Event\EventUpdateRequest,};
use Illuminate\Http\Request;

/**
 * Interface para padrinizar os metodos CRUD no controller
 */
interface CrudEventControllerInterface
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
     * @param Request $request
     * @return mixed
     */
    public function create(EventCreateRequest $request);

    /**
     * Atualiza um registro
     *
     * @param Request $request
     * @return mixed
     */
    public function update(EventUpdateRequest $request);

    /**
     * Deleta um registro
     *
     * @param Request $request
     * @return mixed
     */
    public function delete(EventDeleteRequest $request);
}
