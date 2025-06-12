<?php

namespace App\Models\Todos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'assignee',
        'due_date',
        'time_tracked',
        'status',
        'priority'
    ];

    protected $casts = [
        'due_date' => 'date'
    ];

    protected $attributes = [
        'status' => 'pending',
        'time_tracked' => 0,
    ];
}