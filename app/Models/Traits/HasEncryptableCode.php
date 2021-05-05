<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;

trait HasEncryptableCode
{
    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected static function bootHasEncryptableCode(): void
    {
        static::created(function (Model $model): void {
            $model->forceFill(['code' => Crypt::encryptString(
                Str::upper(get_class($model) . '-' . $model->id)
            )])->saveQuietly();
        });
    }
}
