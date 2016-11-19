<?php
use App\TabelDetailFile;
    function indonesiaDate($date) {

	   	if ($date=="0000-00-00") {
	   		return " ";
	   	} else {
			$months = [
			'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
			'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
			];
			$dates = explode('-', $date);
			return $dates[2] . ' ' . $months[intval($dates[1]) - 1] . ' ' . $dates[0];
   		}
   	}

    function indonesiaSortDate($date) {

      if ($date=="0000-00-00") {
        return " ";
      } else {
      $months = [
      'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 
      'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'
      ];
      $dates = explode('-', $date);
      return $dates[2] . ' ' . $months[intval($dates[1]) - 1] . ' ' . $dates[0];
      }
    }

   	function dateDMY($date) {

    	$timestamp = strtotime($date);

    	if ($date == "0000-00-00") {
    		return " ";
    	} else {
			return date('d-m-Y', $timestamp);  
    	}
        	
   	}

    function dateDMYoneWeek($date) {

        // date_default_timezone_set('asia/jakarta');
        // $start_date = date('Y-m-d');  
        $date = strtotime($date);
        $date = strtotime("+7 day", $date);
        return date('d-m-Y', $date); 
    
    }

    function date3ago($date) {

        // date_default_timezone_set('asia/jakarta');
        // $start_date = date('Y-m-d');  
        $date = strtotime($date);
        $date = strtotime("+3 day", $date);
        return date('m d Y H:i:s', $date); 
    
    }

    function comparedate($date) {

        // date_default_timezone_set('asia/jakarta');
        // $start_date = date('Y-m-d');  
        $date = strtotime($date);
        return date('m d Y H:i:s', $date); 
    
    }

    function comparedate3($date) {

        // date_default_timezone_set('asia/jakarta');
        // $start_date = date('Y-m-d');  
        $date = strtotime($date);
        $date = strtotime("+3 day", $date);
        return date('m d Y H:i:s', $date); 
    
    }

    function cekFile($idfile) {

      $nim = Session::get('nim');
      $detailfile = TabelDetailFile::where('NIM', '=', ($nim))->where('ID_FILE', '=', ($idfile))->get(['ID_FILE']);
      foreach ($detailfile as $data) {
        return $data->ID_FILE;
      }

    }

    function firstName($name) {
      
      $names = explode(" ", $name);
      $lastname = $names[count($names) - 1];
      unset($names[count($names)-1]);
      $firstname = join(' ', $names);
      // return $firstname. '=' .$lastname;
      // return $firstname;
      if ($firstname == null) {
          return $lastname;
      } else {
          return $firstname;
      }
          
    }

    function cekverifikasi($nim) {
      
      $verifikasi = DB::Table('detail_verifikasi')
        ->where('detail_verifikasi.NIM', '=', $nim)
        ->get();

      return $verifikasi;
    }

    function cekPesan($nim, $idfile) {
      
      $pesan = TabelDetailFile::where('NIM', '=', $nim)->where('ID_FILE', '=', $idfile)->pluck('PESAN');

      return $pesan;
    }
