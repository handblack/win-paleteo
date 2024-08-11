<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VlReason extends Model
{
    use HasFactory;
    protected $fillable = [
        'identity',
        'shortname',
        'isactive',
        'token',
        'created_by',
        'updated_by',
    ];
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

     

    
}
