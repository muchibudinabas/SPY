<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelJenisPinjam extends Model
{

    protected $table = 'jenis_pinjam';

    protected $primaryKey = 'ID_JENIS_PINJAM';

    protected $fillable = ['ID_JENIS_PINJAM', 'JENIS_PINJAM'];

    public $timestamps = false;

}

