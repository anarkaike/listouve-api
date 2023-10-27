<?php

namespace App\Contracts\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{
    User\UserCreateRequest,
    User\UserDeleteRequest,
    User\UserUpdateRequest,
};

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
     * @param UserCreateRequest $request
     * @return mixed
     */
    public function create(UserCreateRequest $request);

    /**
     * Atualiza um registro
     *
     * @param UserUpdateRequest $request
     * @return mixed
     */
    public function update(UserUpdateRequest $request);

    /**
     * Deleta um registro
     *
     * @param UserDeleteRequest $request
     * @return mixed
     */
    public function delete(UserDeleteRequest $request);
}
