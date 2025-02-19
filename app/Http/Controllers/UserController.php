<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
//
        dd(1);
        return view('profile.index');
    }

    public function setAvatar()
    {
        dd(2);
    }
}
