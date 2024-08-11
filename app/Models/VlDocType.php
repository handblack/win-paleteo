<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlDocType extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctypename',
        'doctypecode',
        'shortname',
        'isactive',
        'doctype_group_id',
        'token',
    ];

    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

    public function doctypegroup(){
        return $this->hasOne(VlDocTypeGroup::class,'id','doctype_group_id');
    }

}
