<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserAddress extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user_address';
    
    public function user() {
		return $this->hasOne('App\Models\User', 'id', 'id_customer');
	}
}
