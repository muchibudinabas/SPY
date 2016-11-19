<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
	// table yang akan digunakan
	public $table = 'provinsi';

	// fungsi untuk pencarian kolom dengan Query Scope
	public function scopeSearchProvinsi($query, $q) {
		if ($q) return $query->where('nama_provinsi','LIKE', '%'.$q.'%');
	}
}