<?php

namespace App\Models;

use App\Services\FileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;

    public $guarded = [];

    public function question() : BelongsTo {
        return $this->belongsTo(Question::class);
    }


    public static function boot() {

        parent::boot();

        /**
         * Write code on Method
         *
         * @return response()
         */
        static::creating(function($item) {

            // $item->path_thumbnail = FileService::createThumbWebp($item->path);
            
        });
   
    }
}
