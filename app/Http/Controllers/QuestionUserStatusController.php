<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\UserStatusStore;
use App\Models\QuestionUserStatus;

class QuestionUserStatusController extends Controller
{
    public function set(UserStatusStore $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $status = QuestionUserStatus::updateOrCreate(
            ['question_id' => $data['question_id'], 'user_id' => $data['user_id']],
            $data
        );

        return response()->json(['status' => $status]);
    }
}
