<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Question;
use App\Models\QuestionComments;

class CommentController extends Controller
{
    public function store(StoreRequest $request){

        $data = $request->validated();

        try {
            $data['user_id'] = auth()->id();

            $question = QuestionController::findByUrl(url()->previous());
            $comment = Comment::firstOrCreate(['text' => $data['text'], 'user_id' => $data['user_id']], $data);

            if ($comment->wasRecentlyCreated){
                QuestionComments::create([
                    'question_id' => $question->id,
                    'comment_id' => $comment->id,
                ]);
            }
            
            return redirect()->route('question.detail', $question->code);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
