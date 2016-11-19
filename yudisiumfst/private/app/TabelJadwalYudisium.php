<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelJadwalYudisium extends Model
{

    protected $table = 'jadwal_yudisium';

    protected $primaryKey = 'ID_JADWAL_YUDISIUM'; 

    protected $fillable = ['ID_JADWAL_YUDISIUM', 'ID_PERIODE_WISUDA', 'YUDISIUM', 'TGL_YUDISIUM', 'STATUS_JADWAL_YUDISIUM'];

    public $timestamps = false;

}

