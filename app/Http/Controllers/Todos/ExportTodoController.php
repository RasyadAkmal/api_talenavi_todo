<?php

namespace App\Http\Controllers\Todos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todos\ExportTodoRequest;
use App\Services\Todos\TodoService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Todos\TodoExport;

class ExportTodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function generateExcel(ExportTodoRequest $exportTodoRequest)
    {
        $request = $exportTodoRequest->validated();

        $todos = $this->todoService->getTodos($request);

        return Excel::download(new TodoExport($todos), 'todos_report.xlsx');
    }
}