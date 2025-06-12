<?php

namespace App\Services\Todos;

use App\Repositories\Todos\TodoRepository;
use Exception;
use Illuminate\Support\Facades\Cache;
use Log;

class TodoService
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function createTodo(array $data)
    {
        try {
            Cache::forget('status_summary');
            Cache::forget('priority_summary');
            Cache::forget('assignee_summary');
            
            return $this->todoRepository->create($data);
        } catch (Exception $exception) {
            Log::error($exception);
            throw $exception;
        }
    }

    public function getTodos(array $filters)
    {
        return $this->todoRepository->getAll($filters);
    }
}