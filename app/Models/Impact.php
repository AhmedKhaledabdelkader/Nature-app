<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Impact extends Model
{
    
    use HasTranslations ;

    public $incrementing = false;   
    protected $keyType = 'string';  

    protected $fillable = [
        'impactName',
        'impactNumber',
        'impactLogo',
    ];


    public $translatable=["impactName"];

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
