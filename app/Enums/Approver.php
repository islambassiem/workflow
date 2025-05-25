<?php

namespace App\Enums;

enum Approver: int
{
    case ROLE = 1;

    case USER = 2;

    public function lable(): string
    {
        return match ($this) {
            Approver::ROLE => app()->getLocale() == 'en' ? 'Role' : 'وظيفة',
            Approver::USER => app()->getLocale() == 'en' ? 'Emplopyee' : 'موظف',
        };
    }
}
