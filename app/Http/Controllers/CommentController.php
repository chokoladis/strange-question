<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\QuestionComments;
use Illuminate\Support\Facades\Request;

class CommentController extends Controller
{
    public function store(StoreRequest $request)
    {

//        test
        $data = $request->validated();
        Comment::create($data);
        return redirect()->route('questions.index');

//        dd(1);
//        $data = $request->validated();

        try {
            $data['user_id'] = auth()->id();

            if ($data['comment_reply']){

            }

            dump($data);

            $question = QuestionController::findByUrl(url()->previous());
            $comment = Comment::firstOrCreate(['text' => $data['text'], 'user_id' => $data['user_id']], $data);

            dump($comment);

            if ($comment->wasRecentlyCreated){
                QuestionComments::create([
                    'question_id' => $question->id,
                    'comment_id' => $comment->id,
                ]);

                $message = 'success';
            } else {
                $message = 'exists';
            }

//            dd(1);

            return redirect()->back()->with('message', $message);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
