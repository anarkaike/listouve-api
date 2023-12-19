<?php

namespace App\Contracts\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{
    EventList\EventListCreateRequest,
    EventList\EventListDeleteRequest,
    EventList\EventListUpdateRequest,
};

interface CrudEventListControllerInterface
{
    public function index(Request $request);

    public function show(Request $request);

    public function store(EventListCreateRequest $request);

    public function update(EventListUpdateRequest $request);

    public function destroy(EventListDeleteRequest $request);
}
