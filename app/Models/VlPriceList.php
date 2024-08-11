<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VlPriceList extends Model
{
    use HasFactory;
    protected $table = 'vl_pricelists';
    protected $fillable = [
        'identity',
        'shortname',
        'isactive',
        'currency_id',
        'created_by',
        'updated_by',
        'token'
    ];
    public function lines(){        return $this->hasMany(VlPriceListLine::class,'pricelist_id','id');}
    public function currency(){     return $this->hasOne(VlCurrency::class,'id','currency_id');}
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

    public function api_pricelist(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"{$request->q}").'%';
        $result = VlPriceList::select(
                                'id as id',
                                'identity as text'
                            )
                            ->orWhere('identity','LIKE',$q)
                            ->orWhere('shortname','LIKE',$q)
                            ->orderBy('identity')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }
}
