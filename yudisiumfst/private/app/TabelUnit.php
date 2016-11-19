<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelUnit extends Model
{

    protected $table = 'unit';

    protected $fillable = ['ID_UNIT', 'uni_ID_UNIT', 'UNIT', 'KETERANGAN_UNIT'];

    public $timestamps = false;

}

