<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelDetailPinjamBuku extends Model
{

    protected $table = 'detail_pinjam_buku';

    protected $fillable = ['ID_PINJAM_BUKU', 'ID_JENIS_PINJAM' , 'NIP', 'ID_KOLEKSI', 'STATUS_PINJAM', 'TGL_KEMBALI'];

    public $timestamps = false;

}

