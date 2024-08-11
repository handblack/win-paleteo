<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VlProductUM extends Model
{
    use HasFactory;
    protected $table = 'vl_product_ums';
    protected $fillable = [
        'umname',
        'shortname',
        'isactive',
    ];

    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

    public function api_product_um(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"{$request->q}").'%';
        $result = VlProductUM::select(
                                'id as id',
                                'umname as text'
                            )
                            ->where('umname','LIKE',$q)
                            ->orderBy('umname')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }

}
