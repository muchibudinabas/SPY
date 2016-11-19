<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelDetailFile extends Model
{

    protected $table = 'detail_file';

    protected $fillable = ['NIM', 'ID_FILE' , 'ID_CLOUD', 'FILE_ALUMNI', 'KETERANGAN', 'PESAN'];

    public $timestamps = false;

}

