<?php

use App\Http\Controllers\Todos\Charts\TodoChartController;
use App\Http\Controllers\Todos\ExportTodoController;
use App\Http\Controllers\Todos\TodoController;
use Illuminate\Support\Facades\Route;

Route::post('/todos', [TodoController::class, 'store']);
Route::get('/todos/report/excel', [ExportTodoController::class, 'generateExcel']);
Route::get('/chart', [TodoChartController::class, 'index']);