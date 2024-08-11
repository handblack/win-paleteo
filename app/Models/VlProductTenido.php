<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VlProductTenido extends Model
{
    use HasFactory;
    protected $fillable = [
        'identity',
        'shortname',
        'isactive',
        'token',
    ];

    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

    public function api_product_tenido(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"{$request->q}").'%';
        $result = VlProductTenido::select(
                                'id as id',
                                'identity as text'
                            )
                            ->where('identity','LIKE',$q)
                            ->orderBy('identity')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }

}
