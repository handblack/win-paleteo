<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VlSalesPerson extends Model
{
    use HasFactory;
    protected $fillable = [
        'identity',
        'shortname',
        'isactive',
        'token',
        'email',
        'phone',
        'created_by',
        'updated_by',
    ];
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}
    public function api_salesperson(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"{$request->q}").'%';
        $result = VlSalesPerson::select(
                                'id as id',
                                'identity as text'
                            )
                            ->orWhere('identity','LIKE',$q)
                            ->orWhere('email','LIKE',$q)
                            ->orWhere('phone','LIKE',$q)
                            ->orderBy('identity')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }    
}
