<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    public static function getCategoriesLevel0(){

        // use cache
        $categories = Category::query()
            ->where('active', true)
            ->where('level', 0)
            ->get();

        return $categories;
    }

    public function getDaughtersCategories(){

        $collection = [];

        if ($this->level === 0){

            $i = 0;

            while(true){
                
                if (isset($childs) && !empty($childs)){

                    $tempArr = new Collection;

                    foreach ($childs as $category) {
                        $catLevel = $category?->first()?->level + 1;
                        $childId = $category?->first()?->id; // ? todo

                        // dump($catLevel, $childId, $category, $category->first());

                        $tempArr->push($category?->first()?->getDaughterCategories($catLevel, $childId));
                    }

                    // dump($childs, $tempArr);

                    $childs = $tempArr;

                } else {
                    $catLevel = $this->level + 1;
                    $childId = $this->id;

                    $childs = $this->getDaughterCategories($catLevel, $childId);
                }

                if ($i > 10)
                    break;

                $i++;
                
                $collection[] = $childs;
            }
        } 

        return $collection;
    }

    public function getDaughterCategories($catLevel, $categoryParentId){

        // dump($catLevel, '..', $categoryParentId);

        return Category::query()
            ->where('level', $catLevel)
            ->where('category_parent_id', $categoryParentId)
            ->get();
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

    // public static function getParents($category, array $collectionResult = []){
        
    //     // use cache
    //     if (isset($category->category_parent_id) 
    //         && $parent = $category->category_parent_id){

    //         try {
    //             $category = Category::query()->where('active', 1)->where('id', $parent)->first();
    //             $collectionResult[$category->id] = $category;
    //             return self::getParents($category, $collectionResult);
    //         } catch (\Throwable $th) {
    //             throw $th;
    //         }
        
    //     }
        
    //     return $collectionResult;
    // }

    // public static function getParentsForList($categories){

    //     $result = [];

    //     foreach ($categories as $category) {

    //         if (isset($category->category_parent_id) && $category->category_parent_id){

    //             $result[$category->category_parent_id][] = $category->id;
    //             // $result[$category->id] = self::getParents($category);

    //         }
            
    //     }

    //     return $result;

    // }

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
