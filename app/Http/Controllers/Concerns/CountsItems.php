<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Collection;

trait CountsItems
{
    /**
     * Count items according to status.
     *
     * @param  string $model
     * @param  \Illuminate\Database\Eloquent\Collection $collection
     * @return array
     */
    protected function getCountOf(string $model, Collection $collection)
    {
        $analyzer = $this->getAnalyzerClass($model);

        return (new $analyzer($collection))->analyze();
    }

    /**
     * Get full class name with namespace of relevant analyzer class.
     *
     * @param  string $model
     * @return string
     */
    protected function getAnalyzerClass(string $model)
    {
        return 'App\\Analytics\\' . class_basename($model) . 'sAnalyzer';
    }
}
