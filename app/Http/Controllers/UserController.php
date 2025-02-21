<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SetAvatarRequest;
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

    public function update(){
//        todo
        dd(1);
        return view('profile.index');
    }

    public function setAvatar(SetAvatarRequest $request)
    {
//        todo
        //        captcha
        $file = $request->file('avatar');

        if ($file->getError()){
            return $file->getErrorMessage();
        }

        $avatar = FileService::save($file, 'users');

        $user = User::find(auth()->id());
        $user->avatar_id = $avatar->id;
        $user->save();

        return redirect()->route('profile.index');
    }
}
