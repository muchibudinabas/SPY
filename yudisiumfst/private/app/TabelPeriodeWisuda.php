<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelPeriodeWisuda extends Model
{

    protected $table = 'periode_wisuda';

    protected $primaryKey = 'ID_PERIODE_WISUDA'; 

    protected $fillable = ['ID_PERIODE_WISUDA', 'TGL_WISUDA', 'DESKRIPSI', 'STATUS_PERIODE_WISUDA'];

    public $timestamps = false;

}

