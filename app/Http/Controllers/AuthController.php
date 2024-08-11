<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login2(){
        return view('auth.login2');
    }

    
    public function login2_submit(Request $request){
        $request->validate([
            'email'     => 'required',
            'password'  => 'required',
        ]);
        if(env('APP_ENV','local') == 'local'){
            $credentials = [
                'email'     => $request->email,
                'password'  => $request->password,
                'isactive'  => 'Y',
            ];
            if (Auth::attempt($credentials)){
                return redirect()->intended('dashboard');
            }
            return back()->withErrors(['error' => 'Error en credenciales.']);
        }else{
            //Estamos en produccion y ejecutamos validacion con LDAP
            $mail = $this->authenticate2($request->email,$request->password);
            $user = User::where('email',$mail)->first();
            if($user){
                Auth::login($user);
                return redirect()->intended('dashboard');
            }
            return back()->withErrors(['error' => 'Error en credenciales.']);
        }
    }

    public function login(){
        return view('auth.login');
    }

    public function login_submit(Request $request){
        $request->validate([
            'email'     => 'required',
            'password'  => 'required',
        ]);
        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password,
            'isactive'  => 'Y',
        ];
        if (Auth::attempt($credentials)){
            return redirect()->intended('dashboard');
        }
        return back()->withErrors(['error' => 'Error en credenciales.']);
    }

    public function dashboard(){
        return view('dashboard.index');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('home');
    }

    function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }

    public function building(){
        return view('building');
    }

    
    private function authenticate2($user, $password) {
        $ldap_usr_dom   = '@contactbpo.pe';
        $LDAP_LastName  = 'SIN';
        $un = strtolower(trim($user) . $ldap_usr_dom);  // => llombardi@contactbpo.pe
            $usr = User::whereEmail($un)->first();
            if($usr){
                $usr->name      = $user;
                $usr->lastname  = $LDAP_LastName;
                $usr->password  = Hash::make($password);
            }else{
                $usr = new User();
                $usr->name      = $user;
                $usr->email     = $un;
                $usr->lastname  = $LDAP_LastName;
                $usr->password  = Hash::make($password);
                $usr->token     = User::get_token();
                $usr->isactive  = 'Y';
                $usr->isadmin   = 'N';
                $usr->team_id   = 1;
                $usr->save();
            }
            return $un;
    }

    private function authenticate($user, $password) {
        if(empty($user) || empty($password)){
            return false;
        } 
        $ldap_host = "ldap://contact.com";
        $ldap_dn = "DC=contact,DC=com";
        $ldap_usr_dom = '@contactbpo.pe';
        $ldap = ldap_connect($ldap_host);
        ldap_set_option($ldap,LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($ldap,LDAP_OPT_REFERRALS,0);
        if($bind = ldap_bind($ldap, "contact\\".$user, $password)) {
            $access = 2;
        }else { 
            $access = 1;
            ldap_unbind($ldap); 
        }

        if($access == 2) {
            // establish session variables
            #$_SESSION['user'] = $user;
            #$_SESSION['access'] = $access;
            $filter = "(sAMAccountName=" . $user . ")";
            $attr = array("memberof");
            $result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server");
            $entries = ldap_get_entries($ldap, $result);
            
            
            for ($x=0; $x<$entries['count']; $x++){
                    $LDAP_LastName = "";                                
                    if (!empty($entries[$x]['dn'][0])) {
                        $LDAP_LastName = explode(",",explode("CN=",$entries[$x]['dn'])[1])[0];
                        if ($LDAP_LastName == "NULL"){
                            $LDAP_LastName = "";
                        }
                    }
                
                } //END for loop
            ldap_unbind($ldap);
            // Registro al usuario en la plataforma
            $un = strtolower(trim($user) . $ldap_usr_dom);  // => llombardi@contactbpo.pe
            $usr = User::whereEmail($un)->first();
            if($usr){
                $usr->name      = $user;
                $usr->lastname  = $LDAP_LastName;
                $usr->password  = Hash::make($password);
            }else{
                $usr = new User();
                $usr->name      = $user;
                $usr->email     = $un;
                $usr->lastname  = $LDAP_LastName;
                $usr->password  = Hash::make($password);
                $usr->token     = User::get_token();
                $usr->isactive  = 'Y';
                $usr->isadmin   = 'N';
                $usr->team_id   = 1;
                $usr->save();
            }
            return $un;
        } else {
            return false;
        }
    
    }
    

}
