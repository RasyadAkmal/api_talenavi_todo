<?php

namespace App\Services\Todos\Charts;

use App\Repositories\Todos\TodoRepository;
use Illuminate\Support\Facades\Cache;

class TodoChartService
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getSummary($data)
    {
        $type = array_key_exists('type', $data) ? $data['type'] : 'status';
        
        $cacheKey = "{$type}_summary";
        
        return Cache::remember($cacheKey, 3600, function () use ($type) {
            switch ($type) {
                case 'status':
                    return $this->getStatusSummary();
                case 'priority':
                    return $this->getPrioritySummary();
                case 'assignee':
                    return $this->getAssigneeSummary();
                default:
                    return [];
            }
        });
    }
    
    private function getStatusSummary()
    {
        $summary = $this->todoRepository->getStatusSummary();
        return [
            'status_summary' => [
                'pending' => $summary['pending'] ?? 0,
                'open' => $summary['open'] ?? 0,
                'in_progress' => $summary['in_progress'] ?? 0,
                'completed' => $summary['completed'] ?? 0,
            ]
        ];
    }
    
    private function getPrioritySummary()
    {
        $summary = $this->todoRepository->getPrioritySummary();
        return [
            'priority_summary' => [
                'low' => $summary['low'] ?? 0,
                'medium' => $summary['medium'] ?? 0,
                'high' => $summary['high'] ?? 0,
            ]
        ];
    }
    
    private function getAssigneeSummary(): array
    {
        $summary = $this->todoRepository->getAssigneeSummary();
        return ['assignee_summary' => $summary];
    }
}