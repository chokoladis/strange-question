<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    public $guarded = [];

    public static function getActive(){
        //cache
        return Question::query()->where('active', true)->get();
    }
    
    public function category() : HasOne {
        return $this->hasOne(Category::class);
    }

    public function file() : HasOne {
        return $this->hasOne(File::class);
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
