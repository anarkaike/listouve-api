<?php
namespace App\Repositories\Bi;

use Illuminate\Support\{
    Carbon,
    Facades\DB,
};
use App\Contracts\Repositories\Bi\EventBiRepositoryInterface;
use App\Models\Event;

class EventBiRepository implements EventBiRepositoryInterface
{
    public function __construct(
        protected Event $event
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
        return $this->event->all()->count();
    }

    function getTotalRegisteredToday(): int
    {
        return $this->event->whereDate('created_at', Carbon::today())->count();
    }

    function getTotalRegisteredThisWeek(): int
    {
        $start = Carbon::now()->startOfWeek();  // Segunda-feira
        $end = Carbon::now()->endOfWeek();      // Domingo

        return $this->event->whereBetween('created_at', [$start, $end,])->count();
    }

    function getTotalRegisteredThisMonth(): int
    {
        $start = Carbon::now()->startOfMonth(); // Inicio do mes
        $end = Carbon::now()->endOfMonth();     // Final do mes

        return $this->event->whereBetween('created_at', [$start, $end,])->count();
    }

    function getTotalDeleted(): int
    {
        return $this->event->onlyTrashed()->count();
    }

    function getTotalByCreated(): array
    {
        return (array) $this->event
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
