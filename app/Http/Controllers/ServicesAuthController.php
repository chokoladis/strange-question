<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ServicesAuthController extends Controller
{

    public function googleAuth(Request $request){

        $code = urldecode($request->get('code'));

        if (!empty($code)) {

            if ($data = $this->googleUserToken($code)){

                $userData = $this->googleUserInfo($data);

                $user = User::query()
                    ->where('email', $userData['email'])
                    ->first();

                if (!$user){
                    $password = Str::random(12);

                    $newUser = User::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => $password,
                        'active' => 1,
                        'profile_photo_path' => $userData['picture'],
                    ]);

                    $user = $newUser;
                    // send psw on email
                }

                Auth::login($user);

            } else {
                exit;
            }

        } else {
            throw new Exception("Ошибка параметров");
        }

        return redirect()->route('home');
    }

    public function googleUserToken(string $code){

        try {
            $params = array(
                'client_id'     => env('GOOGLE_AUTH_CLIENT_ID'),
                'client_secret' => env('GOOGLE_AUTH_SECRET'),
                'redirect_uri'  => env('GOOGLE_AUTH_URL'),
                'grant_type'    => 'authorization_code',
                'code'          => $code
            );
                    
            $ch = curl_init('https://accounts.google.com/o/oauth2/token');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $data = curl_exec($ch);
            curl_close($ch);
        
            $data = json_decode($data, true);
            
            if (!empty($data['access_token'])){
                return $data;
            } elseif (isset($data['error']) && !empty($data['error'])) {
                echo 'error -> '.$data['error'];
            } else {
                echo 'Неизвестная ошибка<br>';
                print_r($data);
            }

        } catch (\Throwable $th) {
            throw $th;
        }

        return false;
    }

    public function googleUserInfo(array $data){

        $params = array(
            'access_token' => $data['access_token'],
            'id_token'     => $data['id_token'],
            'token_type'   => 'Bearer',
            'expires_in'   => 3599
        );

        $info = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?' . urldecode(http_build_query($params)));
        $info = json_decode($info, true);

        return $info;
    }
    
}
