<?php

namespace App\Contracts\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{
    Event\EventCreateRequest,
    Event\EventDeleteRequest,
    Event\EventUpdateRequest,
};

interface CrudEventControllerInterface
{
    public function index(Request $request);

    public function show(Request $request);

    public function store(EventCreateRequest $request);

    public function update(EventUpdateRequest $request);

    public function destroy(EventDeleteRequest $request);
}
