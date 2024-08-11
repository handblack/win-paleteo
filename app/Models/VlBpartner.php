<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VlBpartner extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartnertype',
        'bpartnercode',
        'doctype_id',
        'documentno',
        'bpartnername',
        'shortname',
        'address',
        'isactive',
        'salesperson_id',
        'pricelist_id',
        'clasifica_id',
        'ubigeo_id',
    ];
    public function doctype(){      return $this->hasOne(VlDocType::class,'id','doctype_id');}
    public function salesperson(){  return $this->hasOne(VlSalesPerson::class,'id','salesperson_id');}
    public function pricelist(){    return $this->hasOne(VlPriceList::class,'id','pricelist_id');}
    public function clasifica(){    return $this->hasOne(VlParameter::class,'id','clasifica_id');}
    public function ubigeo(){       return $this->hasOne(VlvUbigeo::class,'id','ubigeo_id');}
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

    public function api_bpartner(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"{$request->q}").'%';
        $result = VlBpartner::select(
                                'id as id',
                                'bpartnername as text'
                            )
                            ->orWhere('bpartnername','LIKE',$q)
                            ->orWhere('bpartnercode','LIKE',$q)
                            ->orWhere('documentno','LIKE',$q)
                            ->orderBy('bpartnername')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }
}
