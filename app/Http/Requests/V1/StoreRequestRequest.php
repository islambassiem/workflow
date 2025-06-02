<?php

namespace App\Http\Requests\V1;

use App\Enums\Priority;
use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'workflow_id' => ['required', 'exists:workflows,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'status' => ['nullable', Rule::enum(Status::class)],
            'priority' => ['nullable', Rule::enum(Priority::class)],
            'data' => ['nullable', 'json'],
        ];
    }
}
