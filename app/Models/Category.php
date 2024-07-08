<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use PDO;

class Category extends Model
{
    use HasFactory;

    static $timeCache = 43200;
    
    public $guarded = [];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public static function getCategoriesLevel0(){

        // use cache
        $categories = Category::query()
            ->where('active', true)
            ->where('level', 0)
            ->get();

        return $categories;
    }

    public static function getDaughtersCategories(){

        $categories = Category::query()->where('active', true)->orderBy('level', 'desc')->get();

        $arr = $res = [];

        foreach ($categories as $item) {            
            $arr[$item->level][] = $item;
        }

        foreach($arr as $level => $items){

            foreach ($items as $category) {

                $res[$level][$category->id] = [
                    'category' => $category,
                    'items' => $category->getDaughterCategories($category->level + 1, $category->id)
                ];
            }
        }

        return $res;
    }

    public function getDaughterCategories($catLevel, $categoryParentId){

        // dump($catLevel, '..', $categoryParentId);

        return Category::query()
            ->where('level', $catLevel)
            ->where('category_parent_id', $categoryParentId)
            ->get()
            ->toArray();
    }

    public function getCurrCategoryChilds(){

        // $category = $this;

        $category_childs = Cache::remember($this->id.'_childs', self::$timeCache, function($category){
            dd($category);

            return Category::query()
                ->where('active', 1)
                // ->where('category_parent_id', $category->id)
                ->get();
        });

        return $category_childs;
    }

    public function getParentsCategories(){

        $collection = [];

        if ($this->level > 0){

            while(true){
                $catLevel = isset($parent) && !empty($parent) ? $parent->level - 1 : $this->level - 1;
                $parentId = isset($parent) && !empty($parent) ? $parent->category_parent_id : $this->category_parent_id;

                if (!$parentId || $catLevel < 0){
                    break;
                }

                $parent = isset($parent) && !empty($parent) 
                    ? $parent->getParentCategories($catLevel, $parentId) 
                    : $this->getParentCategories($catLevel, $parentId);

                
                $collection[] = $parent;
            }
        } 

        return $collection;
    }

    public function getParentCategories(int $catLevel, int $parentId){

        return Category::query()
            ->where('level', $catLevel)
            ->where('id', $parentId)
            ->first();
    }

    public static function getActive(){

        // use cache
        $categories = Category::query()->where('active', true)->get();
        
        return $categories;
    }

    public static function getElement($code){
        // use cache 
        return Category::where('code', $code)->first();
    }

    public function file() : HasOne {
        return $this->hasOne(File::class, 'id', 'file_id');
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

        static::deleted(function($item){
            File::find($item->file_id)->delete();
        });

    }
}
