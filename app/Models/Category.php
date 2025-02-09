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
            ->where('parent_id', $categoryParentId)
            ->get()
            ->toArray();
            // imgs
    }

    public function getNLevelChildByCategoryId()
    {
        return Category::query()
            ->where('active', 1)
            ->where('parent_id', $this->id)
            ->where('level', $this->level + 1)
            ->get();
    }

    public function getParents()
    {
        $arParents = [];
        $queryResult = null;

        while(true){
            $parentId = !empty($queryResult) ? $queryResult->parent_id : $this->parent_id;
            $level = !empty($queryResult) ? $queryResult->level - 1 : $this->level - 1;
            if ($queryResult = $this->getParentById($parentId, $level)){
                $arParents[] = $queryResult;
            } else {
                break;
            }
        }

        return $arParents;
    }

    public function getParentById(int $parentId, int $level)
    {
        return Category::query()
            ->where('active', 1)
            ->where('id', $parentId)
            ->where('level', $level)
            ->get()->first();
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
