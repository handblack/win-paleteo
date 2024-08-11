<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    private $provider = 'google';
    public function redirectToProvider()
    {
        // Usamos el servicio directo de GOOGLE OAUTH2
        return Socialite::driver($this->provider)->redirect();
    }

    public function handleProviderCallback()
    {
        $oauth = Socialite::driver($this->provider)->user();
        $logge = UserOAuth::whereProvider($this->provider)
                            ->whereOauthEmail($oauth->email)
                            ->first();
        if(!$logge){
            $logge = UserOAuth::create([
                'provider'      => $this->provider,
                'oauth_id'      => $oauth->id,
                'oauth_name'    => $oauth->name,
                'oauth_email'   => $oauth->email,
                'oauth_token'   => $oauth->token,
            ]);
        }
        // Vinculamos el OAuth con la cuenta local
        $user = User::whereEmail($oauth->email)->first();
        if($user){            
            $logge->user_id = $user->id;
            $logge->save();
            if($user->isactive == 'Y'){
                Auth::login($user);
                return redirect()->intended('dashboard');
            }else{
                return back()->withErrors(['error' => 'Tu cuenta esa desactivada']);
            }
        }else{
            return back()->withErrors(['error' => 'Tu email no tiene autorizacion de acceso al sistema']);
        }
    }
}
