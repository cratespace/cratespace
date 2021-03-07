<?php

namespace App\Models\Traits;

use App\Codes\HashCode;
use Illuminate\Database\Eloquent\Model;

trait Hashable
{
    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected static function bootHashable(): void
    {
        static::created(function (Model $model): void {
            $model->update(['code' => HashCode::generate($model->id)]);
        });
    }
}
