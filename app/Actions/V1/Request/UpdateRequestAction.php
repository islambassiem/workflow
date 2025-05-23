<?php

namespace App\Actions\V1\Request;

use App\Models\Request;

class UpdateRequestAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(Request $request, array $attributes): Request
    {
        $request->update($attributes);

        return $request->load('workflow', 'user');
    }
}
