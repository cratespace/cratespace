<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use App\Resources\Reports\Graph;
use Illuminate\Support\Facades\DB;

trait Graphable
{
    /**
     * Fetch analytics on monthly basis.
     *
     * @param int $userId
     *
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public static function graph($userId = null)
    {
        return Graph::collectDataOf(self, $userId)->make();
    }
}
