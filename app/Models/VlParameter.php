<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlParameter extends Model
{
    use HasFactory;
    protected $fillable = [
        'identity',
        'value',
        'shortname',
        'isactive',
        'isreadonly',
        'parent_id',
        'group_id',
        'token',
    ];

    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}
    
}
