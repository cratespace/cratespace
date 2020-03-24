<?php

namespace App\Models\Traits;

use App\Reports\GraphReport;

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
        return GraphReport::collectDataOf(self, $userId)->make();
    }
}
