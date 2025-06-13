<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role;

class WorkflowRequestStep extends Model
{
    /** @use HasFactory<\Database\Factories\WorkflowRequestStepFactory> */
    use HasFactory;

    protected $fillable = [
        'workflow_request_id',
        'workflow_step_id',
        'order',
        'role_id',
        'action_by',
        'status',
        'comment',
        'approved_at',
        'rejected_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<WorkflowRequest, $this>
     */
    public function request(): BelongsTo
    {
        return $this->belongsTo(WorkflowRequest::class, 'workflow_request_id');
    }

    /**
     * @return BelongsTo<WorkflowStep, $this>
     */
    public function step(): BelongsTo
    {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_id');
    }

    /**
     * @return BelongsTo<Role, $this>
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function actionBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
