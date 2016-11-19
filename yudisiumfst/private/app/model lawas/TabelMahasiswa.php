<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelMahasiswa extends Model
{

    protected $table = 'mahasiswa';

    protected $fillable = ['NIM', 'ID_AKUN', 'NAMA_MAHASISWA', 'ID_PRODI', 'ID_DEPARTEMEN', 'NIP'];

    public $timestamps = false;

}

