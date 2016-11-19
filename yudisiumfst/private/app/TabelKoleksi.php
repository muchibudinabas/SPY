<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelKoleksi extends Model
{

    protected $table = 'koleksi';

    protected $fillable = ['ID_KOLEKSI','ID_JENIS_KOLEKSI', 'JUDUL', 'PENGARANG', 'NO_KLAS'];

    public $timestamps = false;

}

