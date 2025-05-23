<?php

namespace App\Actions\V1\Request;

use App\Models\Request;

class ShowRequestAction
{
    public function handle(Request $request): Request
    {
        return $request->load('workflow', 'user');
    }
}
