<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];

    public function user_comments() : HasOne {
        
        return $this->HasOne(UserComments::class);

    }

    public function user_statuses() : HasMany {
        
        return $this->HasMany(CommentUserStatus::class);

    }

    public static function boot() {

        parent::boot();

        /**
         * Write code on Method
         *
         * @return response()
         */

        static::created(function($item) {
            try {
                $userComment = UserComments::create([
                    'user_id' => auth()->id(),
                    'comment_id' => $item->id
                ]);
    
                if (!$userComment || !$userComment->wasRecentlyCreated){
                    Log::debug(__('Не удалось создать связь комментария - '.$item->id.', пользователя - '. auth()->id));
                }
            } catch (\Throwable $th) {
                Log::debug(__('Исключение при создании связи комментария - '.$item->id.', пользователя - '. auth()->id.' --- '.$th));
            }
        });

    }
}
