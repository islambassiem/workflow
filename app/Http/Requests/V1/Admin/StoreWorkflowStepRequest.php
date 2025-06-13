<?php

namespace App\Http\Requests\V1\Admin;

use App\Models\WorkflowStep;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkflowStepRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create_a_workflow_step', WorkflowStep::class);
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'order' => ['required', 'integer'],
            'role_id' => ['required', 'exists:roles,id'],
            'created_by' => ['nullable', 'exists:users,id'],
            'updated_by' => ['nullable', 'exists:users,id'],
        ];
    }
}
