<?php

namespace App\Enums;

enum Status: int
{
    case PENDING = 1;

    case INPROCESS = 2;

    case APPROVED = 3;

    case COMPLETED = 4;

    public function lable(): string
    {
        return match ($this) {
            Status::PENDING => app()->getLocale() == 'en' ? 'Pending' : 'معلق',
            Status::INPROCESS => app()->getLocale() == 'en' ? 'In process' : 'تحت الإجراء',
            Status::APPROVED => app()->getLocale() == 'en' ? 'Approved' : 'معتمد',
            Status::COMPLETED => app()->getLocale() == 'en' ? 'Completed' : 'مكتمل',
        };
    }
}
