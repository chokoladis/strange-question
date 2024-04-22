<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    
    public $guarded = [];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public static function getActive(){
        // use cache
        return Category::query()->where('active', true)->get();
    }

    public static function getElement($code){
        // use cache 
        return Category::where('code', $code)->first();
    }

    public function categorytable() : MorphTo {
        return $this->morphTo();
    }

    public static function boot() {

        parent::boot();

        /**
         * Write code on Method
         *
         * @return response()
         */
        static::creating(function($item) {
            $item->code = Str::slug(Str::lower($item->title),'-');
        });

    }
}
