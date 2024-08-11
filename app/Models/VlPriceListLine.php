<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlPriceListLine extends Model
{
    use HasFactory;
    protected $table = 'vl_pricelist_lines';
    protected $fillable = [
        'pricelist_id',
        'product_id',
        'priceunit',
        'priceunit_wtax',
        'isactive',
        'token'
    ];
    public function pricelist(){    return $this->hasOne(VlPriceList::class,'id','pricelist_id');}
    public function product(){      return $this->hasOne(VlProduct::class,'id','product_id');}
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}
}
