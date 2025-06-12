<?php

namespace App\Http\Requests\Todos\Charts;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DataTodoChartRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function failedValidation(Validator $validator)
    {
        $code = 'GET-TODO-CHART-FAILED';
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
            'type' => 'required|string|in:status,priority,assignee'
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'The type field is required.',
            'type.in' => 'The type must be one of the following: status, priority, assignee.',
        ];
    }

    public function attributes()
    {
        return [
            'type' => 'Type'
        ];
    }
}