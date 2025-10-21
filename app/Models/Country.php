<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{


    use HasTranslations ;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['countryName'];

    public $translatable=['countryName'];

    
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

 
    public function projects()
    {
        return $this->hasMany(Project::class, 'country_id');
    }
}
