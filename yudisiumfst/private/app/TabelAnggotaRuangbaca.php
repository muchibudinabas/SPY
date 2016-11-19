<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelAnggotaRuangbaca extends Model
{

    protected $table = 'anggota_ruangbaca';
    protected $primaryKey = 'NIM_ANGGOTA'; 

    protected $fillable = ['NIM_ANGGOTA', 'NAMA_ANGGOTA', 'ALAMAT_ANGGOTA', 'ID_PRODI', 'TELPON_ANGGOTA'];

    public $timestamps = false;

}

