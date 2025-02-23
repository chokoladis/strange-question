<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\UserStatusStoreRequest;
use App\Models\CommentUserStatus;

class CommentUserStatusController extends Controller
{
    public function setStatus(UserStatusStoreRequest $request){

        $data = $request->validated();
        $comment_id = intval($data['comment_id']);
        $action = intval($data['action']);

        if ($action !== -1 && $action !== 1) {
            throw new \Exception('Не корректное значение');
        }

        $result = CommentUserStatus::updateOrCreate([
            'comment_id' => $comment_id, 'user_id' => auth()->id()
        ], [
            'status' => $action
        ]);

        return true;
    }
}
