<?php

namespace App\Http\Requests\Todos;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTodoRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function failedValidation(Validator $validator)
    {
        $code = 'STORE-TODO-FAILED';
        $message = $validator->errors();

        throw new HttpResponseException(response()->json([
            'code' => $code,
            'message' => $message
        ], 400));
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'due_date' => 'required|date|after_or_equal:today',
            'time_tracked' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,open,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'assignee.max' => 'The assignee may not be greater than 255 characters.',
            'due_date.after_or_equal' => 'The due date must be a date after or equal to today.',
            'time_tracked.numeric' => 'The time tracked must be a number.',
            'time_tracked.min' => 'The time tracked must be at least 0.',
            'status.in' => 'The status must be one of the following: pending, open, in_progress, completed.',
            'priority.in' => 'The priority must be one of the following: low, medium, high.',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'assignee' => 'Assignee',
            'due_date' => 'Due Date',
            'time_tracked' => 'Time Tracked',
            'status' => 'Status',
            'priority' => 'Priority'
        ];
    }
}