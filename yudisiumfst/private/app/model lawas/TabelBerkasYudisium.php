<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelBerkasYudisium extends Model
{

    protected $table = 'berkas_yudisium';

    protected $fillable = ['ID', 'NAMA_MAHASISWA', 'NIM', 'PRODI', 'IPK', 'SKP', 'SOP', 'SURAT_BEBAS_PINJAM', 'ELPT', 'VERIFIKASI'];

    public $timestamps = false;

}

