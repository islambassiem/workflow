<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkflowRequest extends Model
{
    /** @use HasFactory<\Database\Factories\WorkflowRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'workflow_id',
        'user_id',
        'status',
        'priority',
        'data',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'priority' => Priority::class,
            'data' => 'array',
        ];
    }

    /**
     * @return BelongsTo<Workflow, $this>
     */
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<WorkflowRequestStep, $this>
     */
    public function steps(): HasMany
    {
        return $this->hasMany(WorkflowRequestStep::class)->orderBy('order');
    }

    public function currentStep(): ?WorkflowRequestStep
    {
        return $this->steps()->where('status', Status::PENDING)->orderBy('order')->first();
    }
}
