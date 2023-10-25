<?php

namespace App\Contracts\Controllers;

use App\Http\Requests\{User\UserCreateRequest, User\UserDeleteRequest, User\UserUpdateRequest,};
use Illuminate\Http\Request;

/**
 * Interface para padrinizar os metodos CRUD no controller
 */
interface CrudUserControllerInterface extends CrudControllerInterface
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
    public function create($request);

    /**
     * Atualiza um registro
     *
     * @param Request $request
     * @return mixed
     */
    public function update($request);

    /**
     * Deleta um registro
     *
     * @param Request $request
     * @return mixed
     */
    public function delete($request);
}
