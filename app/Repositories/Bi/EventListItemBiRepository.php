<?php
namespace App\Repositories\Bi;

use App\Contracts\Repositories\Bi\EventListItemBiRepositoryInterface;
use App\Models\EventListItem;
use Illuminate\Support\Carbon;

/**
 * Repositorio de consultas com estatisticas para dasbboard / BI
 */
class EventListItemBiRepository implements EventListItemBiRepositoryInterface
{
    /**
     * Injetamos model EventListItem
     *
     * @param EventListItem $eventListItem
     */
    public function __construct(
        protected EventListItem $eventListItem
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
        return $this->eventListItem->all()->count();
    }

    /**
     * Total de registros criados hoje
     *
     * @return int
     */
    function getTotalRegisteredToday(): int
    {
        return $this->eventListItem->whereDate('created_at', Carbon::today())->count();
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

        return $this->eventListItem->whereBetween('created_at', [$start, $end,])->count();
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

        return $this->eventListItem->whereBetween('created_at', [$start, $end,])->count();
    }

    /**
     * Total de registros deletados
     *
     * @return int
     */
    function getTotalDeleted(): int
    {
        return $this->eventListItem->onlyTrashed()->count();
    }
}
