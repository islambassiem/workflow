<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Approval extends Model
{
    /** @use HasFactory<\Database\Factories\ApprovalFactory> */
    use HasFactory;

    protected $fillable = [
        'approver_id',
        'request_id',
        'step_id',
        'status',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * @return BelongsTo<Request, $this>
     */
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    /**
     * @return BelongsTo<Step, $this>
     */
    public function step(): BelongsTo
    {
        return $this->belongsTo(Step::class, 'step_id');
    }
}
