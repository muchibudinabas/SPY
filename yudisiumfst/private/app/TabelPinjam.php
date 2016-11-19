<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelPinjam extends Model
{

    protected $table = 'pinjam';

    protected $primaryKey = 'ID_PINJAM_BUKU'; 

    protected $fillable = ['ID_PINJAM_BUKU', 'NIP', 'NIM_PEMINJAM', 'TGL_PINJAM'];

    public $timestamps = false;

}

