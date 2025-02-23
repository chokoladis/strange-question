<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SetPhotoRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function setThemeMode(){

        $theme = isset($_COOKIE['theme_mode']) ? $_COOKIE['theme_mode'] : 'dark';
        $theme = $theme === 'dark' ? 'light' : $theme;
        
        dump(Cookie::get('theme_mode'));

        dump($theme);

        Cookie::forget('theme_mode');

        try {
            
            Cookie::forget('theme_mode');

            $response = new Response(1);
            $response->withCookie(cookie('theme_mode', $theme, 360000, '/'));
        } catch (\Throwable $th) {
            throw $th;
        }
        
        return $response;
    }

    public function index(){
        return view('profile.index');
    }

    public function update(UpdateRequest $request){

        $data = $request->validated();
        $user = User::find(auth()->id());
        $user->update($data);

        return redirect()->route('profile.index');
    }

    public function setPhoto(SetPhotoRequest $request)
    {
        //        отправить нейронке на модерацию
        //        todo
        //        captcha
        $file = $request->file('photo');

        if ($file->getError()){
            return $file->getErrorMessage();
        }

        $photo = FileService::save($file, 'users');

        $user = User::find(auth()->id());
        $user->photo_id = $photo->id;
        $user->save();

        return redirect()->route('profile.index');
    }
}
