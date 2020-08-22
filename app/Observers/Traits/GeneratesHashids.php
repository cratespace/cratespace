<?php

namespace App\Observers\Traits;

use App\Support\HashidsCodeGenerator;
use Illuminate\Database\Eloquent\Model;

trait GeneratesHashids
{
    /**
     * Generate unique identification code for given space.
     *
     * @param \Illuminate\Database\Eloquent\Model
     *
     * @return void
     */
    protected function generateHashCode(Model $model): void
    {
        $hashCodeGenerator = new HashidsCodeGenerator();

        $hashCodeGenerator->setOptions([
            'salt' => config('app.key'),
            'id' => $model->id,
        ]);

        $model->code = $model->code ?? $hashCodeGenerator->generate();
    }
}
