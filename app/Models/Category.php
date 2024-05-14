<?php

namespace App\Models;

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
        $ar = [];
        $categories = Category::query()->where('active', true)->get();
        foreach($categories as $category){
            $id = $category['id'];
            $parent = $category['category_parent_id'];
            $test = self::findArray($ar, $parent, ['id']);
            if ($parent){
                $ar[$parent]['items'] = $category;
            } else {
                $ar[$id] = $category;
            }
             
        }
        return $ar;
    }

    static function findArray ($ar, $findValue, $executeKeys){
        $result = array();
    
        foreach ($ar as $k => $v) {
            if (is_array($ar[$k])) {
                $second_result = self::findArray ($ar[$k], $findValue, $executeKeys);
                $result = array_merge($result, $second_result);
                continue;
            }
            if ($v === $findValue) {
                foreach ($executeKeys as $val){
                    $result[] = $ar[$val];
                }
                
            }
        }
        return $result;
    }

    public function getParents(){
        
        // use cache
        $res = '';
        $id = $this->category_parent_id;

        while ($id){
            
            $model = Category::query($id)->where('active', 1)->first();
            if (!$model)
                return $res;

            if ($res){
                $res .= ' ->  <a href="'. route('category.detail', $model->code) .'">'.$model->title.'</a>';
            } else {
                $res = '<a href="'. route('category.detail', $model->code) .'">'.$model->title.'</a>';
            }

            $id = $model->category_parent_id;
        }

        return $res;
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
