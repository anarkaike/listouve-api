<?php

namespace App\Contracts\Actions\Bi;

interface BiActionInterface
{
    public function all();

    function getTotal();

    function getTotalRegisteredToday();

    function getTotalRegisteredThisWeek();

    function getTotalRegisteredThisMonth();

    function getTotalDeleted();
}
