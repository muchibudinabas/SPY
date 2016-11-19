<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelJabatan extends Model
{

    protected $table = 'jabatan';

    protected $primaryKey = 'ID_JABATAN'; 

    protected $fillable = ['ID_JABATAN', 'JABATAN'];

    public $timestamps = false;

}

