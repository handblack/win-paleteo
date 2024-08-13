<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'vl_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'team_id',
        'isactive',
        'program',
        'leader_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}
    public static function get_group($id){ return VlParameter::whereGroupId($id)->get();}
    public static function isgrant($field){
        $grant = VlTeamGrant::select($field)
                            ->whereTeamId(auth()->user()->team_id)
                            ->first();
        if($grant){
            return $grant->$field == 'Y' ? TRUE : FALSE;
        }else{
            VlTeamGrant::create([
                'team_id'   => auth()->user()->team_id,
                'token'     => User::get_token(),
            ]);
            return auth()->user()->isadmin == 'Y' ? TRUE : FALSE;
        }
    }

    public function team(){
        return $this->hasOne(VlTeam::class,'id','team_id');
    }

    public static function get_token(){
        return md5(date('YmdHis')).'-'.random_int(10000,99999).'-'.random_int(10000000,99999999);
    }

    public static function get_param($param,$default = ''){
        $row = VlParameter::whereIdentity($param)
                            ->whereGroupId(1)
                            ->first();
        if(!$row){
            VlParameter::create([
                'identity'  => $param,
                'value'     => $default,
                'group_id'  => 1,
                'token'     => User::get_token(),
            ]);
            $value = $default ? $default : '';
        }else{
            $value = $row->value ? $row->value : '';
        }
        return $value;
    }

    public static function set_param($param,$value){
        VlParameter::whereIdentity($param)
                    ->whereGroupId(1)
                    ->update([
                        'value' => $value
                    ]);
    }

    public function api_user(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"%{$request->q}").'%';
        $result = User::select(
                                'id as id',
                                DB::raw("CONCAT(name,' - ',lastname) as text"),
                            )
                            ->orWhere('name','LIKE',$q)
                            ->orWhere('lastname','LIKE',$q)
                            ->orderBy('lastname')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }
    public function api_asesor(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"%{$request->q}").'%';
        $result = User::select(
                                'id as id',
                                DB::raw("CONCAT(name,' - ',lastname) as text"),
                            )
                            ->where('team_id',1)
                            ->where(function($query) use ($q){
                                $query->orWhere('name','LIKE',$q);
                                $query->orWhere('lastname','LIKE',$q);
                            })
                            ->orderBy('lastname')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }

    public static function  get_message_asesor(){
        return VlAlert::whereUserId(auth()->user()->id)
                        ->whereStatus('P')
                        ->whereIsactive('Y')
                        ->get();
    }
    public static function get_message_supervisor(){
        return VlAlert::whereLeaderId(auth()->user()->id)
                        ->whereStatus('P')
                        ->whereIsactive('Y')
                        ->get();
    }
}


