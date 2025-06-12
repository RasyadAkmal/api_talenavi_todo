<?php

namespace App\Repositories\Todos;

use App\Models\Todos\Todo;
use DB;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository
{
    public function create(array $data): Todo
    {
        return Todo::create($data);
    }

    public function getAll(array $filters): Collection
    {
        $query = Todo::query();

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['assignee'])) {
            $query->whereIn('assignee', explode(',', $filters['assignee']));
        }

        if (isset($filters['start']) && isset($filters['end'])) {
            $query->whereBetween('due_date', [$filters['start'], $filters['end']]);
        }

        if (isset($filters['min']) && isset($filters['max'])) {
            $query->whereBetween('time_tracked', [$filters['min'], $filters['max']]);
        }
        
        if (isset($filters['status'])) {
            $query->whereIn('status', explode(',', $filters['status']));
        }
        
        if (isset($filters['priority'])) {
            $query->whereIn('priority', explode(',', $filters['priority']));
        }

        return $query->get();
    }

    public function getStatusSummary()
    {
        return DB::table('todos')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
    }

    public function getPrioritySummary()
    {
        return DB::table('todos')
            ->select('priority', DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->pluck('total', 'priority');
    }

    public function getAssigneeSummary()
    {
        return DB::table('todos')
            ->select(
                'assignee',
                DB::raw('count(*) as total_todos'),
                DB::raw("sum(case when status = 'pending' then 1 else 0 end) as total_pending_todos"),
                DB::raw("sum(case when status = 'completed' then time_tracked else 0 end) as total_timetracked_completed_todos")
            )
            ->whereNotNull('assignee')
            ->groupBy('assignee')
            ->get()
            ->keyBy('assignee');
    }
}