<?php

namespace App\Contracts\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{
    User\UserCreateRequest,
    User\UserDeleteRequest,
    User\UserUpdateRequest,
};

interface CrudProfileControllerInterface extends CrudControllerInterface
{
    public function index(Request $request);

    public function show(Request $request);

    public function store(UserCreateRequest $request);

    public function update(UserUpdateRequest $request);

    public function destroy(UserDeleteRequest $request);
}
