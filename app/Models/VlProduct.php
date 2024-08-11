<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VlProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'productcode',
        'productname',
        'group_id',
        'familia_id',
        'subfamilia_id',
        'tejido_id',
        'hilatura_id',
        'titulo_id',
        'gama_id',
        'tenido_id',
        'acabado_id',
        'presentacion_id',
        'um_id',
        'isactive',
        'token',
        'created_by',
        'updated_by',
    ];

    public function familia(){      return $this->hasOne(VlProductFamilia::class,'id','familia_id');}
    public function subfamilia(){   return $this->hasOne(VlProductSubFamilia::class,'id','subfamilia_id');}
    public function tejido(){       return $this->hasOne(VlProductTejido::class,'id','tejido_id');}
    public function hilatura(){     return $this->hasOne(VlProductHilatura::class,'id','hilatura_id');}
    public function titulo(){       return $this->hasOne(VlProductTitulo::class,'id','titulo_id');}
    public function gama(){         return $this->hasOne(VlProductGama::class,'id','gama_id');}
    public function tenido(){       return $this->hasOne(VlProductTenido::class,'id','tenido_id');}
    public function acabado(){      return $this->hasOne(VlProductAcabado::class,'id','acabado_id');}
    public function presentacion(){ return $this->hasOne(VlProductPresentacion::class,'id','presentacion_id');}
    public function group(){        return $this->hasOne(VlProductGroup::class,'id','group_id');}
    public function um(){           return $this->hasOne(VlProductUM::class,'id','um_id');}
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

    public function api_product(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"{$request->q}").'%';
        $result = VlProduct::select(
                                'id as id',
                                'productname as text'
                            )
                            ->orWhere('productname','LIKE',$q)
                            ->orWhere('productcode','LIKE',$q)
                            ->orderBy('productname')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }

}
