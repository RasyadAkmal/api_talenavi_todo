<?php

namespace App\Http\Requests\Todos;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExportTodoRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function failedValidation(Validator $validator)
    {
        $code = 'EXPORT-TODO-FAILED';
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
            'title' => 'sometimes|string|max:255',
            'assignee' => 'sometimes|string',
            'start' => 'sometimes|date_format:Y-m-d',
            'end' => 'sometimes|date_format:Y-m-d|after_or_equal:start',
            'min' => 'sometimes|numeric|min:0',
            'max' => 'sometimes|numeric|gte:min',
            'status' => [
                'sometimes',
                'string',
                function ($attribute, $value, $fail) {
                    $statuses = explode(',', $value);
                    $allowed = ['pending', 'open', 'in_progress', 'completed'];
                    foreach ($statuses as $status) {
                        if (!in_array(trim($status), $allowed)) {
                            $fail('The ' . $attribute . ' contains an invalid status value.');
                        }
                    }
                },
            ],
            'priority' => [
                'sometimes',
                'string',
                function ($attribute, $value, $fail) {
                    $priorities = explode(',', $value);
                    $allowed = ['low', 'medium', 'high'];
                    foreach ($priorities as $priority) {
                        if (!in_array(trim($priority), $allowed)) {
                            $fail('The ' . $attribute . ' contains an invalid priority value.');
                        }
                    }
                },
            ],
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'assignee' => 'Assignee',
            'start' => 'Start Date',
            'end' => 'End Date',
            'min' => 'Min Time Tracked',
            'max' => 'Max Time Tracked',
            'status' => 'Status',
            'priority' => 'Priority'
        ];
    }
}