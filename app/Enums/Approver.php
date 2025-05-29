<?php

namespace App\Enums;

enum Approver: string
{
    case ROLE = 'Spatie\Permission\Models\Role';

    case USER = 'App\Models\User';

    public function lable(): string
    {
        return match ($this) {
            Approver::ROLE => app()->getLocale() == 'en' ? 'Role' : 'وظيفة',
            Approver::USER => app()->getLocale() == 'en' ? 'Emplopyee' : 'موظف',
        };
    }
}
