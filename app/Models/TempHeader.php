<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempHeader extends Model
{
    use HasFactory;
    //protected $table = 'vl_temp_header';
    protected $fillable = [
        'user_id',
        'token',
        'module',
    ];

    public function lines(){
        return $this->hasMany(TempLine::class,'temp_id','id');
    }

}
