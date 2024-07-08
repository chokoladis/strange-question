<?php

namespace App\Models;

use App\Services\FileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileCategory extends Model
{
    use HasFactory;

    public $guarded = [];

    public static function boot() {

        parent::boot();

        /**
         * Write code on Method
         *
         * @return response()
         */
        static::created(function($item) {

            // $item->path_thumbnail = FileService::createThumbWebp('category/'.$item->path);
            
        });
   
    }
}
