<?php

namespace App\Http\Requests\V1;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', Rule::enum(Status::class)],
            'data' => ['required', 'json'],
        ];
    }
}
