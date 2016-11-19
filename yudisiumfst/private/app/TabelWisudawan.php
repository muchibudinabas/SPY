<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelWisudawan extends Model
{

    protected $table = 'wisudawan';

    protected $primaryKey = 'NIM';

    protected $fillable = ['NIM','ID_UNIT','ID_JADWAL_YUDISIUM', 'ID_AGAMA', 'PASSWORD_TEMP', 'JENIS_KELAMIN', 'NAMA', 'TGL_TERDAFTAR', 'TGL_LULUS', 'NO_IJAZAH', 'IPK', 'SKS', 'ELPT', 'SKP', 'BIDANG_ILMU', 'JUDUL_SKRIPSI', 'DOSEN_PEMBIMBING_1', 'DOSEN_PEMBIMBING_2', 'TEMPAT_LAHIR', 'TANGGAL_LAHIR', 'ALAMAT', 'TELPON','NAMA_ORTU', 'ALAMAT_ORTU', 'TELPON_ORTU', 'VERIFIKASI', 'VERIFIKASI_KM', 'VERIFIKASI_AK', 'TGL_DAFTAR_YUDISIUM'];

    public $timestamps = false;

}

