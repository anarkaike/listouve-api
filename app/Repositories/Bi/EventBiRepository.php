<?php
namespace App\Repositories\Bi;

use App\Contracts\Repositories\Bi\EventBiRepositoryInterface;
use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Repositorio de consultas com estatisticas para dasbboard / BI
 */
class EventBiRepository implements EventBiRepositoryInterface
{
    /**
     * Injetamos model Event
     *
     * @param Event $event
     */
    public function __construct(
        protected Event $event
    )
    {

    }

    /**
     * Devolve todos os resultados de Bi deste repository em um array
     *
     * @return int[]
     */
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

    /**
     * Total de registros
     *
     * @return int
     */
    function getTotal(): int
    {
        return $this->event->all()->count();
    }

    /**
     * Total de registros criados hoje
     *
     * @return int
     */
    function getTotalRegisteredToday(): int
    {
        return $this->event->whereDate('created_at', Carbon::today())->count();
    }

    /**
     * Total de registros criados esta semana
     *
     * @return int
     */
    function getTotalRegisteredThisWeek(): int
    {
        $start = Carbon::now()->startOfWeek();  // Segunda-feira
        $end = Carbon::now()->endOfWeek();      // Domingo

        return $this->event->whereBetween('created_at', [$start, $end,])->count();
    }

    /**
     * Total de registros criados este mes
     *
     * @return int
     */
    function getTotalRegisteredThisMonth(): int
    {
        $start = Carbon::now()->startOfMonth(); // Inicio do mes
        $end = Carbon::now()->endOfMonth();     // Final do mes

        return $this->event->whereBetween('created_at', [$start, $end,])->count();
    }

    /**
     * Total de registros deletados
     *
     * @return int
     */
    function getTotalDeleted(): int
    {
        return $this->event->onlyTrashed()->count();
    }

    /**
     * Total de registros deletados
     *
     * @return int
     */
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
