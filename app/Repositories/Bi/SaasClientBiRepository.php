<?php
namespace App\Repositories\Bi;

use App\Contracts\Repositories\Bi\SaasClientBiRepositoryInterface;
use App\Models\SaasClient;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class SaasClientBiRepository implements SaasClientBiRepositoryInterface
{
    public function __construct(
        protected SaasClient $saasClient
    )
    {

    }

    public function all(): array
    {
        return [
            'total' => $this->getTotal(),
            'total_deleted' => $this->getTotalDeleted(),
            'total_registered_today' => $this->getTotalRegisteredToday(),
            'total_registered_this_week' => $this->getTotalRegisteredThisWeek(),
            'total_registered_this_month' => $this->getTotalRegisteredThisMonth(),
        ];
    }

    function getTotal(): int
    {
        return $this->saasClient->all()->count();
    }

    function getTotalRegisteredToday(): int
    {
        return $this->saasClient->whereDate('created_at', Carbon::today())->count();
    }

    function getTotalRegisteredThisWeek(): int
    {
        $start = Carbon::now()->startOfWeek();  // Segunda-feira
        $end = Carbon::now()->endOfWeek();      // Domingo

        return $this->saasClient->whereBetween('created_at', [$start, $end,])->count();
    }

    function getTotalRegisteredThisMonth(): int
    {
        $start = Carbon::now()->startOfMonth(); // Inicio do mes
        $end = Carbon::now()->endOfMonth();     // Final do mes

        return $this->saasClient->whereBetween('created_at', [$start, $end,])->count();
    }

    function getTotalDeleted(): int
    {
        return $this->saasClient->onlyTrashed()->count();
    }

    function getTotalByCreated(): array
    {
        return (array) $this->saasClient
            ->select(
                DB::raw(value: 'DATE_FORMAT(created_at, "%d/%m") as date'),
                DB::raw(value: 'COUNT(*) as total')
            )
            ->groupBy(DB::raw(value: 'DATE_FORMAT(created_at, "%d/%m")'))
            ->orderBy(DB::raw(value: 'DATE_FORMAT(created_at, "%d/%m")'))
            ->get()
            ->toArray();
    }
}
