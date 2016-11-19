<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelUserAccount extends Model
{

    protected $table = 'user_account';

    protected $fillable = ['ID_AKUN', 'ID_ROLE', 'USERNAME', 'PASSWORD', 'AKTIVASI_AKUN'];

    public $timestamps = false;

}

