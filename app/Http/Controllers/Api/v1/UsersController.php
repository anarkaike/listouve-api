<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\UserBiAction;
use Illuminate\Http\Request;
use App\Actions\UserAction;
use App\Http\{
    Controllers\Controller,
    Requests\User\UserCreateRequest,
    Requests\User\UserDeleteRequest,
    Requests\User\UserUpdateRequest,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse,
};
use App\Exceptions\User\{
    UserNotFountException,
    UserDeleteException,
};


/**
 * Controllers para os end points relacionado a entidade usuário
 */
class UsersController extends Controller
{
    public function __construct(
        // Obtendo por injeção de dependencia o UserAction e atribuindo ele como propriedade privada
        private UserAction $userAction,
        private UserBiAction $userBiAction,
    )
    {

    }

    /**
     * Action para end point de CRUD - GET /api/v1/users/{id}
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function findById(Request $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $user = $this->userAction->findById(id: $request->route('id'));

            if (!$user) {
                throw new UserNotFountException();
            }

            return new ApiSuccessResponse(
                data: $user->toArray(),
                message: 'Usuário obtido pelo ID com sucesso.'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar buscar um usuário pelo ID.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point de CRUD - GET /api/v1/users
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function listAll(Request $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $user = $this->userAction->listAll();

            return new ApiSuccessResponse(
                data: $user->toArray(),
                message: 'Usuários listados com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar lsitar os usuários.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point CRUD - POST /api/v1/users
     *
     * @param UserCreateRequest $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function create(UserCreateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $user = $this->userAction->create(data: $request->all());

            return new ApiSuccessResponse(
                data: $user->toArray(),
                message: 'Usuário criado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar criar um usuário.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point CRUD - PUT /api/v1/users/{id}
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function update(UserUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $user = $this->userAction->update(id: $request->route('id'), data: $request->validationData());

            return new ApiSuccessResponse(
                data: $user->toArray(),
                message: 'Usuário atualizado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar atualizar um usuário.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point CRUD - DELETE /api/v1/users/{id}
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function delete(UserDeleteRequest $request)
    {
        try {
            $userId = $request->route(param: 'id');

            if(!$this->userAction->delete(id: $userId)) {
                throw new UserDeleteException();
            }

            return new ApiSuccessResponse(
                [],
                message: 'Usuário deletado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar excluir um usuário.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point que retorna dados do BI
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function bi(Request $request)
    {
        try {
            return new ApiSuccessResponse(
                $this->userBiAction->all(),
                message: 'Dados do BI obtidos com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar obter os dados do BI.',
                data: [],
                request: $request
            );
        }
    }
}
