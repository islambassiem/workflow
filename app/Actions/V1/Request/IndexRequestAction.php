<?php

namespace App\Actions\V1\Request;

use App\Models\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexRequestAction
{
    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator<int, \App\Models\Request>
     */
    public function handle(): LengthAwarePaginator
    {
        return Request::paginate();
    }
}
