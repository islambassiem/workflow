<?php

namespace App\Actions\V1\Request;

use App\Models\Request;
use Illuminate\Support\Facades\Auth;

class StoreRequestAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(array $attributes): Request
    {
        $attributes['user_id'] = Auth::id();
        $request = Request::create($attributes);

        return $request->load('workflow', 'user');
    }
}
