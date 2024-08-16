<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlAlert extends Model
{
    use HasFactory;
    protected $fillable = [
        'source_id',
        'subject',
        'leader_id',
        'user_id',
        'message',
        'reponse',
        'path_local',
        'path_public',
        'msg_cliente',
        'msg_mejora',
        'msg_fortaleza',
        'msg_acciones',
    ];
    public function source(){
        return $this->hasOne(VlSource::class,'id','source_id');
    }
    public function leader(){
        return $this->hasOne(User::class,'id','leader_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

}
