<?php

namespace App\Enums;

enum Status: int
{
    case PENDING = 1;

    case INPROCESS = 2;

    case APPROVED = 3;

    case COMPLETED = 4;

    case REJECTED = 5;

    /**
     * @return array<string, string>
     */
    public function lable(): array
    {
        return match ($this) {
            Status::PENDING => ['id' => '1', 'en' => 'Pending', 'ar' => 'قيد الانتظار'],
            Status::INPROCESS => ['id' => '2',  'en' => 'In Process', 'ar' => 'قيد التنفيذ'],
            Status::APPROVED => ['id' => '3',  'en' => 'Approved', 'ar' => 'موافق'],
            Status::COMPLETED => ['id' => '4', 'en' => 'Completed', 'ar' => 'مكتمل'],
            Status::REJECTED => ['id' => '5', 'en' => 'Rejected', 'ar' => 'مرفوض'],
        };
    }
}
