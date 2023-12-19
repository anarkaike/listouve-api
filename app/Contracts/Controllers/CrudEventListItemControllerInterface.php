<?php

namespace App\Contracts\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{
    EventListItem\EventListItemCreateRequest,
    EventListItem\EventListItemDeleteRequest,
    EventListItem\EventListItemUpdateRequest,
};

interface CrudEventListItemControllerInterface
{
    public function index(Request $request);

    public function show(Request $request);

    public function store(EventListItemCreateRequest $request);

    public function update(EventListItemUpdateRequest $request);

    public function destroy(EventListItemDeleteRequest $request);
}
