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
use Illuminate\Support\Facades\Auth;
use App\Exceptions\User\{
    UserNotFountException,
    UserDeleteException,
};


/**
 * Controllers para os en points relacionado a entidade usuário
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
     * Action para en point de CRUD - GET /api/v1/users/{id}
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
                message: trans(key: 'messages.users.find_by_id_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Action para en point de CRUD - GET /api/v1/users
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
                message: trans(key: 'messages.users.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Action para en point CRUD - POST /api/v1/users
     *
     * @param UserCreateRequest $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function create(UserCreateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
//            $data = $request->all();
            $data = $request->validationData();
            $data['created_by'] = Auth::id();
            $user = $this->userAction->create(data: $data);

            return new ApiSuccessResponse(
                data: $user->toArray(),
                message: trans(key: 'messages.users.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Action para en point CRUD - PUT /api/v1/users/{id}
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function update(UserUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['updated_by'] = Auth::id();
            $user = $this->userAction->update(id: $request->route('id'), data: $request->validationData());

            return new ApiSuccessResponse(
                data: $user->toArray(),
                message: trans(key: 'messages.users.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Action para en point CRUD - DELETE /api/v1/users/{id}
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
                message: trans(key: 'messages.users.delete_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Action para en point que retorna dados do BI
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function bi(Request $request)
    {
        try {
            return new ApiSuccessResponse(
                $this->userBiAction->all(),
                message: trans(key: 'messages.users.get_bi_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
