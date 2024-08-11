<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlChangeLog extends Model
{
    use HasFactory;
    protected $dates = ['datelog'];
    protected $casts   = [
        'data_before' => 'object',
        'data_after' => 'object',
    ];
    public function createdby(){    return $this->hasOne(User::class,'id','user_id');}
    
}
