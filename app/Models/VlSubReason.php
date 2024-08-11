<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlSubReason extends Model
{
    use HasFactory;
    protected $fillable = [
        'reason_id',
        'identity',
        'shortname',
        'isactive',
        'token',
        'created_by',
        'updated_by',
    ];
    public function reason(){
        return $this->hasOne(VlReason::class,'id','reason_id');
    }
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}
}
