<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VlUbigeo extends Model
{
    use HasFactory;
    protected $table = 'vl_ubigeo';
    protected $fillable = [
        'ubigeo',
        'dep',
        'pro',
        'dis'
    ];
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

    public function api_ubigeo(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"%{$request->q}").'%';
        $result = VlvUbigeo::select(
                                'id as id',
                                'identity2 as text'
                            )
                            ->orWhere('identity2','LIKE',$q)                            
                            ->orderBy('identity')
                            ->orderBy('ubigeo')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }  
}
