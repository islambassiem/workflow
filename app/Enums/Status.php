<?php

namespace App\Enums;

enum Status: int
{
    case DRAFT = 1;         // Request being prepared
    case PENDING = 2;       // Awaiting approval
    case IN_REVIEW = 3;     // Currently being reviewed
    case APPROVED = 4;      // Fully approved
    case REJECTED = 5;      // Rejected
    case SCHEDULED = 6;     // Approved and scheduled for relocation
    case IN_PROGRESS = 7;   // IT is executing
    case COMPLETED = 8;     // Successfully relocated
    case ON_HOLD = 9;       // Waiting for more info
    case CANCELLED = 10;    // Withdrawn by requester

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending',
            self::IN_REVIEW => 'In Review',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::SCHEDULED => 'Scheduled',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
            self::ON_HOLD => 'On Hold',
            self::CANCELLED => 'Cancelled',
        };
    }
}
