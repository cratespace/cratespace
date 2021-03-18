<?php

namespace App\Models\Traits;

use App\Support\HashId;
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
            $model->update(['code' => HashId::generate($model->id)]);
        });
    }
}
