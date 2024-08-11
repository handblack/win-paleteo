<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlTeam extends Model
{
    use HasFactory;
    protected $fillable = [
        'teamname',
    ];
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}

    public function users(){
        return $this->hasMany(User::class,'team_id');
    }

}
