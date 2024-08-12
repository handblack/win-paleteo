<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VlTeamGrant extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'token'
    ];
    public function team(){
        return $this->hasOne(VlTeam::class,'id','team_id');
    }
    public function createdby(){    return $this->hasOne(User::class,'id','created_by');}
    public function updatedby(){    return $this->hasOne(User::class,'id','updated_by');}
}
