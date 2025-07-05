<?php

namespace App\Enums;

enum Priority: int
{
    case LOW = 1;

    case MEDIUM = 2;

    case HIGH = 3;

    case URGENT = 4;

    /**
     * @return array<string, string>
     */
    public function lable(): array
    {
        return match ($this) {
            Priority::LOW => ['id' => '1', 'en' => 'Low', 'ar' => 'منخفض'],
            Priority::MEDIUM => ['id' => '2', 'en' => 'Medium', 'ar' => 'متوسط'],
            Priority::HIGH => ['id' => '3', 'en' => 'High', 'ar' => 'مرتفع'],
            Priority::URGENT => ['id' => '4', 'en' => 'Urgent', 'ar' => 'عاجل'],
        };
    }
}
