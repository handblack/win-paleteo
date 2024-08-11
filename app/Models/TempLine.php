<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempLine extends Model
{
    use HasFactory;
    //protected $table = 'vl_temp_line';
    protected $fillable = [
        'temp_id',
        'product_id',
    ];

    public function header(){
        return $this->hasOne(TempHeader::class,'id','temp_id');
    }

    public function product(){
        return $this->hasOne(VlProduct::class,'id','product_id');
    }

}
