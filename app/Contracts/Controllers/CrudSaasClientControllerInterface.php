<?php

namespace App\Contracts\Controllers;

use App\Http\Requests\{
    SaasClient\SaasClientCreateRequest,
    SaasClient\SaasClientDeleteRequest,
    SaasClient\SaasClientUpdateRequest,
};
use Illuminate\Http\Request;

/**
 * Interface para padrinizar os metodos CRUD no controller
 */
interface CrudSaasClientControllerInterface
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
     * @param SaasClientCreateRequest $request
     * @return mixed
     */
    public function create(SaasClientCreateRequest $request);

    /**
     * Atualiza um registro
     *
     * @param SaasClientCreateRequest $request
     * @return mixed
     */
    public function update(SaasClientUpdateRequest $request);

    /**
     * Deleta um registro
     *
     * @param SaasClientCreateRequest $request
     * @return mixed
     */
    public function delete(SaasClientDeleteRequest $request);
}
