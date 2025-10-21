<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Partner extends Model
{

        
    use HasTranslations ;

    public $incrementing = false;   
    protected $keyType = 'string';  

    protected $fillable = [
        'partnerName',
        'partnerLogo'
    ];

  

    public $translatable=["partnerName"];

    
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
