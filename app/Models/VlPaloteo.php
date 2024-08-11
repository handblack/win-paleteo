<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlPaloteo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nodo',
        'documentno',
        'did',
        'isincidencia',
        'incidencia_id',
        'subreason_id',
        'isactive',
        'month',
        'comment',
        'datetrx',
        'token',
        'created_by',
        'updated_by',
        'updated_by',
    ];


    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}
}
