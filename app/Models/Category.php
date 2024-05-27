<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use PDO;

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

        $categories = Category::query()->where('active', true)->get();
        
        return $categories;
    }

    public function getParents($category, array $collectionResult = []){
        
        // use cache
        if (isset($category->category_parent_id) 
            && $parent = $category->category_parent_id){

            try {
                $category = Category::query()->where('active', 1)->where('id', $parent)->first();
                $collectionResult[] = $category;
                $this->getParents($category, $collectionResult);
            } catch (\Throwable $th) {
                throw $th;
            }
        
        }
        
        return $collectionResult;
    }

    public static function getElement($code){
        // use cache 
        return Category::where('code', $code)->first();
    }

    public function file() : HasOne {
        return $this->hasOne(FileCategory::class, 'category_id', 'id');
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
