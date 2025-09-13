<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;


class Theme extends Model
{


    use HasTranslations ;

    public $incrementing = false;   
    protected $keyType = 'string';  

    protected $fillable = [
        'themeName',
        'themeDescription',
        'themeImage'
    ];


    public $translatable=["themeName","themeDescription"];

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
