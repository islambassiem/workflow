<?php

namespace App\Enums;

enum Priority: int
{
    case LOW = 1;

    case MEDIUM = 2;

    case HIGH = 3;

    public function lable(): string
    {
        return match ($this) {
            Priority::LOW => app()->getLocale() == 'en' ? 'Low' : 'منخفض',
            Priority::MEDIUM => app()->getLocale() == 'en' ? 'Medium' : 'متوسط',
            Priority::HIGH => app()->getLocale() == 'en' ? 'High' : 'عالي',
        };
    }
}
