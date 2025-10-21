<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Impact extends Model
{
    use HasTranslations;

    public $incrementing = false;   
    protected $keyType = 'string';  

    protected $fillable = [
        'impactName',
        'impactNumber',
        'impactLogo',
    ];

    public $translatable = ['impactName'];

    public function setLocalizedValue(string $field, string $locale, $value): void
    {
        $this->setTranslation($field, $locale, $value);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
