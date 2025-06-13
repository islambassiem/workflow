<?php

namespace App\Http\Requests\V1;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkflowStepRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'workflow_request_id' => ['required', 'exists:workflow_requests,id'],
            'workflow_step_id' => ['required', 'exists:workflow_steps,id'],
            'role_id' => ['required', 'exists:roles,id'],
            'action_by' => ['nullable', 'exists:users,id'],
            'status' => ['required', Rule::enum(Status::class)],
            'comment' => ['nullable', 'max:1000'],
            'approved_at' => ['nullable', 'date'],
            'rejected_at' => ['nullable', 'date'],
        ];
    }
}
