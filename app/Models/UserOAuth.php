<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOAuth extends Model
{
    use HasFactory;
    protected $table = 'vl_user_oauths';
    protected $fillable = [
        'provider',
        'oauth_id',
        'oauth_email',
        'oauth_name',
        'oauth_token',
        'user_id',
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

}
