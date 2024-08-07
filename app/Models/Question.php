<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

        $userId = auth()->id();

        if (!$userId)
            return false;

        $res = QuestionComments::query()
            ->where('question_id', $this->id)
            ->with(['comment' => function($q) {
                $q->where('user_id', auth()->id());
            }, 'comment'])
            ->first();
        
        return $res;
    }

    public function getPopularComment(){
        
        $result = false;

        if ($this->question_comment){

            $query = QuestionComments::where('question_id',$this->id)
                ->join('comment_user_statuses as statuses','question_comments.comment_id','=','statuses.comment_id')
                ->select(['statuses.status','statuses.comment_id'])
                // ->groupBy('statuses.comment_id')
                ->get();

            $comments = [];

            if ($query->isNotEmpty()){
                foreach ($query as $comment) {

                    if (!isset($comments[$comment->comment_id]))
                        $comments[$comment->comment_id] = 0;
    
                    $plus = $comment->status === 'like' ? 1 : -1;
    
                    $comments[$comment->comment_id] = $comments[$comment->comment_id] + $plus;                
                }

                $popularCommentId = array_search(max($comments), $comments);

                $popularComment = Comment::query('id', $popularCommentId)->first();

                return $popularComment;
            }
            
            return false;
        }

        return false;

    }

    // 
    public function category() : HasOne {
        return $this->hasOne(Category::class);
    }

    public function question_comment() : HasMany {
        return $this->HasMany(QuestionComments::class, 'question_id', 'id');
    }

    public function file() : HasOne {
        return $this->hasOne(File::class, 'id', 'file_id');
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
            // File::find($item->file_id)->update(['question_id' => $item->id]);
            QuestionStatistics::create([
                'question_id' => $item->id
            ]);
        });

    }
}
