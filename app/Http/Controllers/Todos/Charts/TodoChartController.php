<?php

namespace App\Http\Controllers\Todos\Charts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todos\Charts\DataTodoChartRequest;
use App\Services\Todos\Charts\TodoChartService;
use Illuminate\Http\Request;

class TodoChartController extends Controller
{
    protected $todoChartService;

    public function __construct(TodoChartService $todoChartService)
    {
        $this->todoChartService = $todoChartService;
    }

    public function index(DataTodoChartRequest $dataTodoChartRequest)
    {
        $request = $dataTodoChartRequest->validated();

        $data = $this->todoChartService->getSummary($request);

        return response()->json($data);
    }
}