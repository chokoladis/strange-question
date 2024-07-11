<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Feedback\StoreRequest;
use App\Models\Feedback;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    
    public function store(StoreRequest $request){
        
        $success = true;
        $response = null;

        try {
            $data = $request->validated();

            // if ($data['email'])

            if (isset($data['phone']) && $data['phone']){
                preg_match_all('/[\d]/', $data['phone'], $matches);
                $phone = implode('', $matches[0]);

                if (strlen($phone) !== 11){
                    $success = false;
                    $error = 'Ошибка заполнения телефона';
                }
            }
            // if ($data[''])

            if ($success){
                $check = Feedback::firstOrCreate([
                    'email' => $data['email'],
                    'comment' => $data['comment']
                ], $data);
    
                if ($check->wasRecentlyCreated){
                    $response = 'Заявка успешно отправлена';
                } else {
                    $success = false;
                    $error = 'Ваша заявка уже отправлена и ожидает обработки';
                }
            }

            dump($data);

            return responseJson($success, $response, $error);
        } catch (\Throwable $th) {

            Log::error($th, $data);

            throw $th;
        }
    }
}
