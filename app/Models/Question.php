<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    public $guarded = [];

    public static function getElement($code){
        // use cache 
        return Question::where('code', $code)->where('active', true)->first();
    }

    public static function getActive(){
        //cache
        return Question::query()->where('active', true)->get();
    }
    
    public static function getTopPopular(){
        //cache
        $query = Question::query()
            ->where('active', true)
            ->with(['statistics' => function($q) {
                    $q->orderBy('views', 'desc');
                }, 'statistics'])
            ->limit(10)
            ->get();

        return $query;
    }

    public function getCurrentUserComment(){
        $res = null;

        if (!empty($this->question_comment->toArray()))
            $res = $this->question_comment?->comment;
        // add check current user
        
        return $res;
    }

    // 
    public function category() : HasOne {
        return $this->hasOne(Category::class);
    }

    public function question_comment() : HasMany {
        return $this->HasMany(QuestionComments::class, 'question_id', 'id');
    }

    public function file() : HasOne {
        return $this->hasOne(File::class, 'question_id', 'id');
    }

    public function statistics() : HasOne {
        return $this->hasOne(QuestionStatistics::class, 'question_id', 'id');
    }

    // 
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

        static::created(function($item) {
            File::find($item->file_id)->update(['question_id' => $item->id]);
            QuestionStatistics::create([
                'question_id' => $item->id
            ]);
        });

    }
}
