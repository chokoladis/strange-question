<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\CommentsReply;
use App\Models\QuestionComments;
use Illuminate\Support\Facades\Request;

class CommentController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $comment_reply_id = $data['comment_reply_id'];
        unset($data['comment_reply_id']);

        $question = QuestionController::findByUrl(url()->previous());
        $comment = Comment::firstOrCreate(['text' => $data['text'], 'user_id' => $data['user_id']], $data);

        if ($comment->wasRecentlyCreated){
            QuestionComments::create([
                'question_id' => $question->id,
                'comment_id' => $comment->id,
            ]);
            CommentsReply::create([
                'comment_main_id' => $comment->id,
                'comment_reply_id' => $comment_reply_id,
            ]);

            $message = 'success';
        } else {
            $message = 'exists';
        }

        return redirect()->back()->with('message', $message);
    }
}
