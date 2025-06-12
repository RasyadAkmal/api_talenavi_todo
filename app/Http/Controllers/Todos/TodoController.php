<?php

namespace App\Http\Controllers\Todos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todos\StoreTodoRequest;
use App\Http\Resources\Todos\TodoResource;
use App\Services\Todos\TodoService;
use Exception;
use Log;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function store(StoreTodoRequest $storeTodoRequest)
    {
        try {
            $request = $storeTodoRequest->validated();

            $todo = $this->todoService->createTodo($request);

            $response = [
                'code' => 'STORE-TODO-SUCCESS',
                'message' => 'Successfully created todo',
                'data' => new TodoResource($todo)
            ];

            return response()->json($response, 201);
        } catch (Exception $e) {
            Log::error($e);

            $response = [
                'code' => 'STORE-TODO-FAILED',
                'message' => 'Something went wrong when creating todo'
            ];

            return response()->json($response, 500);
        }
    }
}