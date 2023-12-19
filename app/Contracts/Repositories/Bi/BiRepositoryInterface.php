<?php

namespace App\Contracts\Repositories\Bi;

interface BiRepositoryInterface
{
    public function all(): array;

    function getTotal(): int;

    function getTotalRegisteredToday(): int;

    function getTotalRegisteredThisWeek(): int;

    function getTotalRegisteredThisMonth(): int;

    function getTotalDeleted(): int;
}
