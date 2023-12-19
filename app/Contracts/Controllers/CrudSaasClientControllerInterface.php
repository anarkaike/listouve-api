<?php

namespace App\Contracts\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{
    SaasClient\SaasClientCreateRequest,
    SaasClient\SaasClientDeleteRequest,
    SaasClient\SaasClientUpdateRequest,
};

interface CrudSaasClientControllerInterface
{
    public function index(Request $request);

    public function show(Request $request);

    public function store(SaasClientCreateRequest $request);

    public function update(SaasClientUpdateRequest $request);

    public function destroy(SaasClientDeleteRequest $request);
}
