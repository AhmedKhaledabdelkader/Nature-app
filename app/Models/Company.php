<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Company extends Model
{

    public $incrementing = false;
    protected $keyType = 'string';

    use HasTranslations ;


    protected $fillable = [
        'company_name',
        'company_description',
        'company_image',
        'company_logo',
    ];


public $translatable=["company_name","company_description"];



 public function setLocalizedValue(string $field, string $locale, $value): void
    {
        $this->setTranslation($field, $locale, $value);
    }


    
protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }


    
}
