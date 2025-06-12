<?php

namespace App\Http\Resources\Todos;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'assignee' => $this->assignee,
            'due_date' => $this->due_date->format('Y-m-d'),
            'time_tracked' => $this->time_tracked,
            'status' => $this->status,
            'priority' => $this->priority,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}