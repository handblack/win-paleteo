<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlSequence extends Model
{
    use HasFactory;
    protected $fillable = [
        'serial',
        'doctype_id',
        'isactive',
        'token',
    ];
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

    public function get_lastnumber($sequence_id){
        $row = VlSequence::whereId($sequence_id)->first();
        return $row ? $row->lastnumber +1 : null;
    }

    public function set_lastnumber($sequence_id){
        $row = VlSequence::whereId($sequence_id)->first();
        $row->lastnumber++;
        $row->save(); 
        return $row->lastnumber;
    }

    public function doctype(){
        return $this->hasOne(VlDocType::class,'id','doctype_id');
    }



}
