<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TabelFileYudisium extends Model
{

    protected $table = 'file_yudisium';

    protected $primaryKey = 'ID_FILE';  

    protected $fillable = ['ID_FILE', 'NAMA_FILE' , 'INISIAL', 'STATUS'];

    public $timestamps = false;

}

