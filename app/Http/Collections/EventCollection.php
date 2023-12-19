<?php

namespace App\Http\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EventCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
