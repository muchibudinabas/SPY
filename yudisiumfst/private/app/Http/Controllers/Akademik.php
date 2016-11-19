<?php
namespace App\Http\Controllers;

use Input, Validator, Response, Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

use App\TabelWisudawan;
use App\TabelJabatan;
use App\TabelUnit;
use App\TabelJenis;
use App\TabelAgama;
use App\TabelPegawai;
use App\TabelPeriodeWisuda;
use App\TabelJadwalYudisium;
use App\TabelUserAccount;
use App\TabelFileYudisium;
use App\TabelDetailFile;
use App\TabelCloudStorage;
use App\TabelDetailVerifikasi;
use App\Http\Controllers\belajarcontroler;
use App\User;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Auth\Guard;
use View;
use Hash;
use Session;
use Auth;
use Mail;
use Flash;
use App\Quotation;
use Carbon\Carbon;
use File;
use Excel;


class Akademik extends Controller
{
    public function listYudisium()
    {
      $idjabatan = Session::get('jabatan');

      if (Session::has('access') && $idjabatan == "4") {
          $person = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
              ->where('wisudawan.VERIFIKASI_AK','=','0')
              ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
              ->get();

          $nip = Session::get('nip');
          $profile = TabelPegawai::where('NIP','=',$nip)
          ->get();

          return View::make('akademik.list_yudisium', compact('person', 'profile'));
      } else {
          return redirect('logout');
      }

    }

    public function edit($id)
    {
        $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->find($id);   
        return Response::json($person);
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

    public function inputNoIjazah(Request $request, $id)
    {

      $TGL_LULUS     = Input::get('TGL_LULUS');
      // $TGL           = date("d-m-Y",strtotime($TGL_LULUS));

      $NIM           = Input::get('NIM');
      $NAMA          = Input::get('NAMA');
      $JENIS_KELAMIN = Input::get('JENIS_KELAMIN');
      $UNIT         = Input::get('UNIT');
      $NO_IJAZAH     = Input::get('NO_IJAZAH');
      $IPK           = Input::get('IPK');
      $SKS           = Input::get('SKS');
      $ELPT          = Input::get('ELPT');
      // $SKP           = Input::get('SKP');




        $rules = array(
                       'TGL_LULUS'   => 'required',
                       'NO_IJAZAH'   => 'required',
                       'IPK'         => array('required', 'max:4', 'regex:/^([2]+\.[0-9]+[0-9])|([3]+\.[0-9]+[0-9])|([4]+\.[0]+[0])+$/i'),
                       'SKS'         => 'required|numeric|min:36',
                       'ELPT'        => 'required|numeric|min:450|max:677',

                      );
        $custom = array(
                       'TGL_LULUS.required' => 'Tanggal Lulus is required.',
                       'NO_IJAZAH.required' => 'No Ijazah is required.',
                       'IPK.required' => 'IPK is required.',
                       'IPK.regex' => 'IPK range (2.00-4.00).',
                       'IPK.max' => 'IPK range (2.00-4.00).',
                       'ELPT.required' => 'ELPT is required.',
                       'ELPT.numeric' => 'ELPT must be a number.',
                       'ELPT.min' => 'ELPT min 450.',
                       'ELPT.max' => 'ELPT max 677.',
                       'SKS.required' => 'SKS is required.',
                       'SKS.numeric' => 'SKS must be a number.',
                       'SKS.min' => 'SKS min 36.',

                      );

        $validator = Validator::make(Input::all(), $rules, $custom);
 
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                // 'errors'   => $validator->errors()->toArray(),
                'errors'   =>$validator->errors(),
                ]);
        }

        $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->findOrFail($id);

        $person->update($request->all());

        if ($JENIS_KELAMIN == '1') {
          $JENIS_KELAMIN = 'Laki-laki';
        } else if ($JENIS_KELAMIN == '2') {
          $JENIS_KELAMIN = 'Perempuan';
        }
        
        $TGL = $this->indonesiaSortDate($TGL_LULUS);
        $SKP = TabelWisudawan::where('NIM','=',$id)->pluck('SKP');
        if ($SKP == null) {
          $SKP = ' ';
        } else {
          $SKP = $SKP;
        }
        

        $person = array(
                    'NIM'               => $NIM, 
                    'NAMA'              => $NAMA,
                    'JENIS_KELAMIN'     => $JENIS_KELAMIN,
                    'TGL_LULUS'         => $TGL,
                    'UNIT'              => $UNIT,
                    'NO_IJAZAH'         => $NO_IJAZAH,
                    'IPK'               => $IPK,
                    'SKS'               => $SKS,
                    'ELPT'              => $ELPT,
                    'SKP'               => $SKP,
                     );

        return response()->json([
               'success'  => true,
               'data' => $person
               ]);
    }
    
    public function datetime(){
        date_default_timezone_set('asia/jakarta');
        $datetime = date('Y-m-d H:i:sa');
        return $datetime;
    }

    public function verifikasiAk(Request $request, $id)
    {

        $idjabatan = Session::get('jabatan');
        
        if (Session::has('access') && $idjabatan == "4") {

          $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                  ->findOrFail($id);

          $person->update(['VERIFIKASI_AK' => 1]);

          $nip        = Session::get('nip');
          $username   = TabelUserAccount::where('NIP','=',$nip)->pluck('USERNAME');

          $cekverifikasi = TabelDetailVerifikasi::where('NIM', '=', $id)->where('USERNAME', '=', $username)->get();

          if ($cekverifikasi->count() > 0) {
              DB::table('detail_verifikasi')->where('NIM', $id)->where('USERNAME', $username)
                  ->update([
                  'TGL_DETAIL_VERIFIKASI' => $this->datetime(),
                  ]);
          } else {
              DB::table('detail_verifikasi')->insert([
                  'NIM'                   => $id,
                  'USERNAME'              => $username,
                  'TGL_DETAIL_VERIFIKASI' => $this->datetime(),           
                  ]);
          }

          return response()->json([
                 'success'  => true,
                 'data' => $person
                 ]);

        } else {
            return redirect('logout');
        }
    }

    public function detailMahasiswa($nim) 
    {

      $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "2") {

                $data = DB::Table('wisudawan','unit','agama')
                ->where('wisudawan.NIM','=',$nim)
                ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')
                ->join('jadwal_yudisium','wisudawan.ID_JADWAL_YUDISIUM','=','jadwal_yudisium.ID_JADWAL_YUDISIUM')
                ->join('periode_wisuda','jadwal_yudisium.ID_PERIODE_WISUDA','=','periode_wisuda.ID_PERIODE_WISUDA')
                ->get();

                $data2 = DB::Table('wisudawan','detail_file')
                ->where('wisudawan.NIM','=',$nim)
                ->join('detail_file','wisudawan.NIM','=','detail_file.NIM')
                ->get();

                $nip = Session::get('nip');
                $profile = TabelPegawai::where('NIP','=',$nip)
                ->get();

                $username  = TabelUserAccount::where('NIP','=',$nip)
                    ->pluck('USERNAME');

                $verifikasi = DB::Table('detail_verifikasi', 'user_account', 'pegawai', 'jabatan')
                ->where('detail_verifikasi.NIM', '=', $nim)
                ->join('user_account','detail_verifikasi.USERNAME','=','user_account.USERNAME')
                ->join('pegawai','user_account.NIP','=','pegawai.NIP')
                ->join('jabatan','pegawai.ID_JABATAN','=','jabatan.ID_JABATAN')
                ->get();

                $nim = DB::Table('wisudawan')
                ->where('wisudawan.NIM','=',$nim)
                ->get(['NIM']);
                foreach ($nim as $nim1) {
                  Session::put('nim', $nim1->NIM);
                  $nim = $nim1->NIM;//tambah baru
                }

                return View::make('prodi.detail_mhs', compact('data', 'profile', 'data2', 'verifikasi', 'nim'));
        
        } else if (Session::has('access') && $idjabatan == "4") {


               $data = DB::Table('wisudawan','unit','agama')
                ->where('wisudawan.NIM','=',$nim)
                ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')
                ->join('jadwal_yudisium','wisudawan.ID_JADWAL_YUDISIUM','=','jadwal_yudisium.ID_JADWAL_YUDISIUM')
                ->join('periode_wisuda','jadwal_yudisium.ID_PERIODE_WISUDA','=','periode_wisuda.ID_PERIODE_WISUDA')
                ->get();

                $data2 = DB::Table('wisudawan','detail_file')
                ->where('wisudawan.NIM','=',$nim)
                ->join('detail_file','wisudawan.NIM','=','detail_file.NIM')
                ->get();

                $nip = Session::get('nip');
                $profile = TabelPegawai::where('NIP','=',$nip)
                ->get();

                $username  = TabelUserAccount::where('NIP','=',$nip)
                    ->pluck('USERNAME');

                $verifikasi = DB::Table('detail_verifikasi', 'user_account', 'pegawai', 'jabatan')
                ->where('detail_verifikasi.NIM', '=', $nim)
                ->join('user_account','detail_verifikasi.USERNAME','=','user_account.USERNAME')
                ->join('pegawai','user_account.NIP','=','pegawai.NIP')
                ->join('jabatan','pegawai.ID_JABATAN','=','jabatan.ID_JABATAN')
                ->get();
                
                $nim = DB::Table('wisudawan')
                ->where('wisudawan.NIM','=',$nim)
                ->get(['NIM']);
                foreach ($nim as $nim1) {
                  Session::put('nim', $nim1->NIM);
                  $nim = $nim1->NIM;//tambah baru

                }
            return View::make('akademik.detail_mhs', compact('data',  'profile', 'data2', 'verifikasi', 'nim'));
        } 
        else {
            return redirect('logout');
        }
    }

    public function detailMahasiswaWisudawan($nim) 
    {

      $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "4") {

                $data = DB::Table('wisudawan','unit','agama')
                ->where('wisudawan.NIM','=',$nim)
                ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')
                ->join('jadwal_yudisium','wisudawan.ID_JADWAL_YUDISIUM','=','jadwal_yudisium.ID_JADWAL_YUDISIUM')
                ->join('periode_wisuda','jadwal_yudisium.ID_PERIODE_WISUDA','=','periode_wisuda.ID_PERIODE_WISUDA')
                ->get();

                $data2 = DB::Table('wisudawan','detail_file')
                ->where('wisudawan.NIM','=',$nim)
                ->join('detail_file','wisudawan.NIM','=','detail_file.NIM')
                ->get();

                $nip = Session::get('nip');
                $profile = TabelPegawai::where('NIP','=',$nip)
                ->get();

                $username  = TabelUserAccount::where('NIP','=',$nip)
                    ->pluck('USERNAME');

                $verifikasi = DB::Table('detail_verifikasi', 'user_account', 'pegawai', 'jabatan')
                ->where('detail_verifikasi.NIM', '=', $nim)
                ->join('user_account','detail_verifikasi.USERNAME','=','user_account.USERNAME')
                ->join('pegawai','user_account.NIP','=','pegawai.NIP')
                ->join('jabatan','pegawai.ID_JABATAN','=','jabatan.ID_JABATAN')
                ->get();

                $nim = DB::Table('wisudawan')
                ->where('wisudawan.NIM','=',$nim)
                ->get(['NIM']);
                foreach ($nim as $nim1) {
                  Session::put('nim', $nim1->NIM);
                  $nim = $nim1->NIM;//tambah baru
                }

                return View::make('akademik.detail_mhs_wisudawanak', compact('data', 'profile', 'data2', 'verifikasi', 'nim'));
        
        } else {
            return redirect('logout');
        }
    }

    public function dataWisudawan() {

      $idjabatan = Session::get('jabatan');

      if (Session::has('access') && $idjabatan == "4") {

          $person = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
          ->where('wisudawan.VERIFIKASI_AK','=','1')
          ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
          ->get();

          $nip = Session::get('nip');
          $profile = TabelPegawai::where('NIP','=',$nip)->get();

          $pw = TabelPeriodeWisuda::orderBy('ID_PERIODE_WISUDA', 'DESC')->get();  

          return View::make('akademik.data_alumni', compact('person', 'profile', 'pw'));

      } else {
          return redirect('logout');
      }
    }

    public function dataWisudawanPeriodeWisuda($id) {

      $idjabatan = Session::get('jabatan');

      if (Session::has('access') && $idjabatan == "4") {

          if ($id == 1) {
             $person = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                  ->where('wisudawan.VERIFIKASI_AK','=','1')
                  ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                  ->get();

            $idperiodewisuda = 1;
            Session::put('idperiodewisuda', $idperiodewisuda);

            $pw = TabelPeriodeWisuda::all(); 

            $nip = Session::get('nip');
            $profile = TabelPegawai::where('NIP','=',$nip)->get();

            return View::make('akademik.detailsalumni', compact('person', 'idperiodewisuda', 'profile', 'pw'));

          } else if ($id != 1) {
            $person = DB::Table('wisudawan', 'unit', 'jadwal_yudisium')
                  ->where('wisudawan.VERIFIKASI', '=', '1')
                  ->where('wisudawan.VERIFIKASI_AK', '=', '1')
                  ->where('jadwal_yudisium.ID_PERIODE_WISUDA', '=', $id)
                  ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                  ->join('jadwal_yudisium','wisudawan.ID_JADWAL_YUDISIUM','=','jadwal_yudisium.ID_JADWAL_YUDISIUM')
                  ->get();

            $idperiodewisuda = DB::Table('periode_wisuda')
                  ->where('ID_PERIODE_WISUDA','=',$id)
                  ->get(['ID_PERIODE_WISUDA']);

            foreach ($idperiodewisuda as $id1) {
                    Session::put('idperiodewisuda', $id1->ID_PERIODE_WISUDA);
                  }

            $pw = TabelPeriodeWisuda::all(); 

            $nip = Session::get('nip');
            $profile = TabelPegawai::where('NIP','=',$nip)->get();

            return View::make('akademik.detailsalumni', compact('person', 'idperiodewisuda', 'profile', 'pw'));
          }
          



      } else {
          return redirect('logout');
      }
    }

    public function periodeWisudaa()
    {
        $nip = Session::get('nip');
        if (Session::has('access') && Session::get('nip') == $nip) {

            $person = TabelPeriodeWisuda::all();

            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();

            return View::make('akademik.periode_wisuda', compact('person','profile'));

        } else {
            return redirect('logout');
        }

    }
    public function jadwalYudisium()
    {
        $nip = Session::get('nip');
        if (Session::has('access') && Session::get('nip') == $nip) {

            $person2 = TabelJadwalYudisium::join('periode_wisuda','jadwal_yudisium.ID_PERIODE_WISUDA','=','periode_wisuda.ID_PERIODE_WISUDA')->get();

            $id = Session::get('id');
            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();

            $pw = TabelPeriodeWisuda::where('STATUS_PERIODE_WISUDA', '=', '1')->get();
            return View::make('akademik.jadwal_yudisium', compact('person2','profile', 'pw'));

        } else {
            return redirect('logout');
        }

    }
    public function file_yudisium()
    {
      $idjabatan = Session::get('jabatan');
     
        if (Session::has('access') && $idjabatan == "4") {
            $person3 = TabelFileYudisium::where('file_yudisium.STATUS', '=', '1')->join('jadwal_yudisium', 'file_yudisium.ID_JADWAL_YUDISIUM', '=', 'jadwal_yudisium.ID_JADWAL_YUDISIUM')->get();

            $jy = TabelJadwalYudisium::where('STATUS_JADWAL_YUDISIUM', '=', '2')->get();

            $nip = Session::get('nip');
            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();

            return View::make('akademik.file_yudisium', compact('person3', 'jy', 'profile'));

        } else {
            return redirect('logout');
        }

    }

    public function getlastidperiodewisuda()
    {
      date_default_timezone_set('asia/jakarta');
      $years = date('Y');
      $data = DB::table('periode_wisuda')->where('ID_PERIODE_WISUDA', 'like', ''.($years).'%')->orderBy('ID_PERIODE_WISUDA', 'desc')->skip(0)->take(1)->get(['ID_PERIODE_WISUDA']);

        foreach ($data as $data1) {
            return $data1->ID_PERIODE_WISUDA;
        }
    }

    public function storePeriodewisuda(Request $request)
    {
      $ID_PERIODE_WISUDA = $this->getlastidperiodewisuda();

      $substr = substr($ID_PERIODE_WISUDA, 0, 4);
      $substr4 = substr($ID_PERIODE_WISUDA,4,1);

      $plus = $substr4+1;

      if ($substr==null) {
        date_default_timezone_set('asia/jakarta');
        $years = date('Y');
        $id = 1;
          $ID_PERIODE_WISUDA = $years.$id;
      } else {
          $ID_PERIODE_WISUDA = $substr.$plus;
      }

      $TGL_WISUDA     = Input::get('TGL_WISUDA');
      $DESKRIPSI    = Input::get('DESKRIPSI');
      $STATUS_PERIODE_WISUDA    = Input::get('STATUS_PERIODE_WISUDA');
      if ($STATUS_PERIODE_WISUDA == '1') {
        $Tampilkan    = 'Tampilkan';
        $Sembunyikan    = '';
      } if ($STATUS_PERIODE_WISUDA == '0') {
        $Tampilkan    = '';
        $Sembunyikan    = 'Sembunyikan';
      }

       $rules = array(
                       'TGL_WISUDA'        => 'required',
                       'DESKRIPSI'   => 'required',
                       'STATUS_PERIODE_WISUDA'   => 'required',
                      );
        $custom = array(
                       'TGL_WISUDA.required' => 'Tanggal Wisuda is required.',
                       'DESKRIPSI.required' => 'Deskripsi is required.',
                       'STATUS_PERIODE_WISUDA.required' => 'Status is required.',

                      );

        $validator = Validator::make(Input::all(), $rules, $custom);
            
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'errors'   => $validator->errors()->toArray()
                ]);
        }

        if ($STATUS_PERIODE_WISUDA == '1') {
          $cekidperiode = TabelPeriodeWisuda::all()->where('STATUS_PERIODE_WISUDA', '1');

          if ($cekidperiode->count() > 0) {
            return response()->json([
                  'success' => false,
                  'errors'   => ["Maaf Status Tampilkan sudah dipakai untuk periode wisuda lain"]
                  ]);
          } else {

            $idWisuda = $this->getlastidperiodewisuda();
            $value = 1;

            $person2 = DB::table('periode_wisuda')->insert([

            'ID_PERIODE_WISUDA'      => ($ID_PERIODE_WISUDA),
            'TGL_WISUDA'     => $TGL_WISUDA,
            'DESKRIPSI'   => $DESKRIPSI,
            'STATUS_PERIODE_WISUDA'   => $STATUS_PERIODE_WISUDA,

            ]);

            $person2 = array(
            'TGL_WISUDA'      => $this->indonesiaDate($TGL_WISUDA),
            'DESKRIPSI'          => $DESKRIPSI,
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,
            );
            // $person2 = TabelPeriodeWisuda::create($request->all());

            return response()->json([
                   'success'  => true,
                   'data' => $person2
                   ]);
          
          }
        }

        if ($STATUS_PERIODE_WISUDA == '0') {
          $idWisuda = $this->getlastidperiodewisuda();
            $value = 1;

            $person2 = DB::table('periode_wisuda')->insert([

            'ID_PERIODE_WISUDA'      => ($ID_PERIODE_WISUDA),
            'TGL_WISUDA'     => $TGL_WISUDA,
            'DESKRIPSI'   => $DESKRIPSI,
            'STATUS_PERIODE_WISUDA'   => $STATUS_PERIODE_WISUDA,

            ]);

            $person2 = array(
            'TGL_WISUDA'      => $this->indonesiaDate($TGL_WISUDA),
            'DESKRIPSI'          => $DESKRIPSI,
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,
            );
            // $person2 = TabelPeriodeWisuda::create($request->all());

            return response()->json([
                   'success'  => true,
                   'data' => $person2
                   ]);
        }



    }
    public function periodeWisuda($id)
    {
        $person = TabelPeriodeWisuda::find($id);   
        return Response::json($person);
    }

    public function updatePeriodewisuda(Request $request, $id)
    {
      $TGL_WISUDA     = Input::get('TGL_WISUDA');
      $DESKRIPSI    = Input::get('DESKRIPSI');
      $STATUS_PERIODE_WISUDA    = Input::get('STATUS_PERIODE_WISUDA');
      if ($STATUS_PERIODE_WISUDA == '1') {
        $Tampilkan    = 'Tampilkan';
        $Sembunyikan    = '';
      } if ($STATUS_PERIODE_WISUDA == '0') {
        $Tampilkan    = '';
        $Sembunyikan    = 'Sembunyikan';
      }

        $rules = array(
                       'TGL_WISUDA'   => 'required',
                       'DESKRIPSI'        => 'required',
                       'STATUS_PERIODE_WISUDA'        => 'required',
                      );
        $custom = array(
                       'TGL_WISUDA.required' => 'Tanggal Wisuda is required.',
                       'DESKRIPSI.required' => 'Deskripsi is required.',
                       'STATUS_PERIODE_WISUDA.required' => 'Status is required.',
                      );

        $validator = Validator::make(Input::all(), $rules, $custom);
 
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                // 'errors'   => $validator->errors()->toArray(),
                'errors'   =>$validator->errors(),
                ]);
        }


        if ($STATUS_PERIODE_WISUDA == '1') {
          

          $cekstatusperiode = TabelPeriodeWisuda::all()->where('STATUS_PERIODE_WISUDA', '1');

          if ($cekstatusperiode->count() > 0) {
            // return 'jangan diinput';
            return response()->json([
                  'success' => false,
                  'errors'   => ["Maaf Status Tampilkan sudah dipakai untuk periode wisuda lain"]
                  ]);
          } else {
            
            $person = TabelPeriodeWisuda::findOrFail($id);

            $person->update($request->all());

            $person = array(
            'TGL_WISUDA'      => $this->indonesiaDate($TGL_WISUDA),
            'DESKRIPSI'          => $DESKRIPSI,
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,


            );

            return response()->json([
                   'success'  => true,
                   'data' => $person
                   ]);
          
          }
        
        }

        if ($STATUS_PERIODE_WISUDA == '0') {

            DB::table('wisudawan')->where('VERIFIKASI', '0')->delete();

            $person = TabelPeriodeWisuda::findOrFail($id);

            $person->update($request->all());

            DB::table('jadwal_yudisium')->where('ID_PERIODE_WISUDA', $id)
                      ->update([
                      'STATUS_JADWAL_YUDISIUM' => '0',
                      ]);
            
            $idjadwalyudisium = TabelJadwalYudisium::where('ID_PERIODE_WISUDA', $id)->get(['ID_JADWAL_YUDISIUM']);
            foreach ($idjadwalyudisium as $idjy) {
              DB::table('file_yudisium')->where('ID_JADWAL_YUDISIUM', $idjy->ID_JADWAL_YUDISIUM)
                        ->update([
                        'STATUS' => '2',
                        ]);
            }

            $person = array(
            'TGL_WISUDA'      => $this->indonesiaDate($TGL_WISUDA),
            'DESKRIPSI'          => $DESKRIPSI,
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,

            );

            return response()->json([
                   'success'  => true,
                   'data' => $person
                   ]);
          
          }

          



        
    }

    public function storeJadwalyudisium(Request $request)
    {
      $ID_PERIODE_WISUDA     = Input::get('ID_PERIODE');
      $YUDISIUM     = Input::get('YUDISIUM');
      $TGL_YUDISIUM    = Input::get('TGL_YUDISIUM');
      $STATUS_JADWAL_YUDISIUM    = Input::get('STATUS_JADWAL_YUDISIUM');
      if ($STATUS_JADWAL_YUDISIUM == '1') {
        $Tampilkan    = 'Tampilkan';
        $Sembunyikan    = '';
        $TampilkanAktif    = '';
      } if ($STATUS_JADWAL_YUDISIUM == '2') {
        $Tampilkan    = '';
        $Sembunyikan    = '';
        $TampilkanAktif    = 'Tampilkan & Aktif';
      } if ($STATUS_JADWAL_YUDISIUM == '0') {
        $Tampilkan    = '';
        $Sembunyikan    = 'Sembunyikan';
        $TampilkanAktif    = ''; 
      }

       $rules = array(
                       'ID_PERIODE'   => 'required',
                       'YUDISIUM'   => 'required',
                       'TGL_YUDISIUM'   => 'required',
                       'STATUS_JADWAL_YUDISIUM'        => 'required',
                      );
        $custom = array(
                       'ID_PERIODE.required' => 'Periode Wisuda is required.',
                       'YUDISIUM.required' => 'Yudisium is required.',
                       'TGL_YUDISIUM.required' => 'Tanggal Yudisium is required.',
                       'STATUS_JADWAL_YUDISIUM.required' => 'Status is required.',
                      );

        $validator = Validator::make(Input::all(), $rules, $custom);
            
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'errors'   => $validator->errors()->toArray()
                ]);
        }

        if ($STATUS_JADWAL_YUDISIUM == '2') {

          $cekstatusjy = TabelJadwalYudisium::all()->where('STATUS_JADWAL_YUDISIUM', '2');
          if ($cekstatusjy->count() > 0) {
            // return 'jangan diinput';
            return response()->json([
                  'success' => false,
                  'errors'   => ["Maaf Status Tampilkan & Aktif sudah dipakai untuk jadwal yudisium lain"]
                  ]);
          } else {
            # code...
            $data = DB::table('jadwal_yudisium')->where('ID_JADWAL_YUDISIUM', 'like', ''.($ID_PERIODE_WISUDA).'%')->orderBy('ID_JADWAL_YUDISIUM', 'desc')->skip(0)->take(1)->get();
            
            foreach ($data as $dataa) {
              $data = $dataa->ID_JADWAL_YUDISIUM;
            }

            if ($data==null) {
              $plus = 1;
              $ID_JADWAL_YUDISIUM = $ID_PERIODE_WISUDA.$plus;
            } else {

              $substr = substr($data, 0, 5);
              $substr5 = substr($data,5,1);
              $plus = $substr5+1;


              if ($substr==null) {
                $id = 1;
                $ID_JADWAL_YUDISIUM = $substr.$id;
              } else 
              {
                $ID_JADWAL_YUDISIUM = $substr.$plus;
              }
            }
            
            $person2 = DB::table('jadwal_yudisium')->insert([
            'ID_JADWAL_YUDISIUM'      => $ID_JADWAL_YUDISIUM,
            'ID_PERIODE_WISUDA'      => $ID_PERIODE_WISUDA,
            'YUDISIUM'   => $YUDISIUM,
            'TGL_YUDISIUM'     => $TGL_YUDISIUM,
            'STATUS_JADWAL_YUDISIUM'   => $STATUS_JADWAL_YUDISIUM,
            ]);

            $data = TabelPeriodeWisuda::where('ID_PERIODE_WISUDA', '=', ($ID_PERIODE_WISUDA))->get();
            foreach ($data as $dataa) {
              $data = $dataa->TGL_WISUDA;
            }
            // return $this->indonesiaDate($data);

            $person2 = array(
            'TGL_WISUDA'      => $this->indonesiaDate($data),
            'YUDISIUM'          => $YUDISIUM,
            'TGL_YUDISIUM'          => $this->indonesiaDate($TGL_YUDISIUM),
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,
            'TampilkanAktif'          => $TampilkanAktif,

            );

            return response()->json([
                   'success'  => true,
                   'data' => $person2
                   ]);
          }
          
        } 
        if ($STATUS_JADWAL_YUDISIUM == '1') {

          $data = DB::table('jadwal_yudisium')->where('ID_JADWAL_YUDISIUM', 'like', ''.($ID_PERIODE_WISUDA).'%')->orderBy('ID_JADWAL_YUDISIUM', 'desc')->skip(0)->take(1)->get();
            
            foreach ($data as $dataa) {
              $data = $dataa->ID_JADWAL_YUDISIUM;
            }

            if ($data==null) {
              $plus = 1;
              $ID_JADWAL_YUDISIUM = $ID_PERIODE_WISUDA.$plus;
            } else {

              $substr = substr($data, 0, 5);
              $substr5 = substr($data,5,1);
              $plus = $substr5+1;


              if ($substr==null) {
                $id = 1;
                $ID_JADWAL_YUDISIUM = $substr.$id;
              } else 
              {
                $ID_JADWAL_YUDISIUM = $substr.$plus;
              }
            }
            
            $person2 = DB::table('jadwal_yudisium')->insert([
            'ID_JADWAL_YUDISIUM'      => $ID_JADWAL_YUDISIUM,
            'ID_PERIODE_WISUDA'      => $ID_PERIODE_WISUDA,
            'YUDISIUM'   => $YUDISIUM,
            'TGL_YUDISIUM'     => $TGL_YUDISIUM,
            'STATUS_JADWAL_YUDISIUM'   => $STATUS_JADWAL_YUDISIUM,
            ]);

            $data = TabelPeriodeWisuda::where('ID_PERIODE_WISUDA', '=', ($ID_PERIODE_WISUDA))->get();
            foreach ($data as $dataa) {
              $data = $dataa->TGL_WISUDA;
            }
            // return $this->indonesiaDate($data);

            $person2 = array(
            'TGL_WISUDA'      => $this->indonesiaDate($data),
            'YUDISIUM'          => $YUDISIUM,
            'TGL_YUDISIUM'          => $this->indonesiaDate($TGL_YUDISIUM),
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,
            'TampilkanAktif'          => $TampilkanAktif,

            );

            return response()->json([
                   'success'  => true,
                   'data' => $person2
                   ]);

        } 
        if ($STATUS_JADWAL_YUDISIUM == '0') {

          $data = DB::table('jadwal_yudisium')->where('ID_JADWAL_YUDISIUM', 'like', ''.($ID_PERIODE_WISUDA).'%')->orderBy('ID_JADWAL_YUDISIUM', 'desc')->skip(0)->take(1)->get();
            
            foreach ($data as $dataa) {
              $data = $dataa->ID_JADWAL_YUDISIUM;
            }

            if ($data==null) {
              $plus = 1;
              $ID_JADWAL_YUDISIUM = $ID_PERIODE_WISUDA.$plus;
            } else {

              $substr = substr($data, 0, 5);
              $substr5 = substr($data,5,1);
              $plus = $substr5+1;


              if ($substr==null) {
                $id = 1;
                $ID_JADWAL_YUDISIUM = $substr.$id;
              } else 
              {
                $ID_JADWAL_YUDISIUM = $substr.$plus;
              }
            }
            
            $person2 = DB::table('jadwal_yudisium')->insert([
            'ID_JADWAL_YUDISIUM'      => $ID_JADWAL_YUDISIUM,
            'ID_PERIODE_WISUDA'      => $ID_PERIODE_WISUDA,
            'YUDISIUM'   => $YUDISIUM,
            'TGL_YUDISIUM'     => $TGL_YUDISIUM,
            'STATUS_JADWAL_YUDISIUM'   => $STATUS_JADWAL_YUDISIUM,
            ]);

            $data = TabelPeriodeWisuda::where('ID_PERIODE_WISUDA', '=', ($ID_PERIODE_WISUDA))->get();
            foreach ($data as $dataa) {
              $data = $dataa->TGL_WISUDA;
            }
            // return $this->indonesiaDate($data);

            $person2 = array(
            'TGL_WISUDA'      => $this->indonesiaDate($data),
            'YUDISIUM'          => $YUDISIUM,
            'TGL_YUDISIUM'          => $this->indonesiaDate($TGL_YUDISIUM),
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,
            'TampilkanAktif'          => $TampilkanAktif,

            );

            return response()->json([
                   'success'  => true,
                   'data' => $person2
                   ]);

        }


    }


    public function editJadwalyudisium($id)
    {
        $person2 = TabelJadwalYudisium::find($id);   
        return Response::json($person2);
    }

    public function updateJadwalyudisium(Request $request, $id)
    {
        $ID_PERIODE_WISUDA     = Input::get('ID_PERIODE');
        $YUDISIUM     = Input::get('YUDISIUM');
        $TGL_YUDISIUM    = Input::get('TGL_YUDISIUM');
        $STATUS_JADWAL_YUDISIUM    = Input::get('STATUS_JADWAL_YUDISIUM');
        if ($STATUS_JADWAL_YUDISIUM == '1') {
          $Tampilkan    = 'Tampilkan';
          $Sembunyikan    = '';
          $TampilkanAktif    = '';
        } if ($STATUS_JADWAL_YUDISIUM == '2') {
          $Tampilkan    = '';
          $Sembunyikan    = '';
          $TampilkanAktif    = 'Tampilkan & Aktif';
        } if ($STATUS_JADWAL_YUDISIUM == '0') {
          $Tampilkan    = '';
          $Sembunyikan    = 'Sembunyikan';
          $TampilkanAktif    = ''; 
        }

        // return $ID_PERIODE_WISUDA;

        $rules = array(
                       'ID_PERIODE'   => 'required',
                       'YUDISIUM'   => 'required',
                       'TGL_YUDISIUM'   => 'required',
                       'STATUS_JADWAL_YUDISIUM'        => 'required',
                      );
        $custom = array(
                       'ID_PERIODE.required' => 'Periode Wisuda is required.',
                       'YUDISIUM.required' => 'Yudisium is required.',
                       'TGL_YUDISIUM.required' => 'Tanggal Yudisium is required.',
                       'STATUS_JADWAL_YUDISIUM.required' => 'Status is required.',
                      );

        $validator = Validator::make(Input::all(), $rules, $custom);
 
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                // 'errors'   => $validator->errors()->toArray(),
                'errors'   =>$validator->errors(),
                ]);
        }

        if ($STATUS_JADWAL_YUDISIUM == '2') {
          

          $cekstatusperiode = TabelJadwalYudisium::all()->where('STATUS_JADWAL_YUDISIUM', '2');

          if ($cekstatusperiode->count() > 0) {
            // return 'jangan diinput';
            return response()->json([
                  'success' => false,
                  'errors'   => ["Maaf Status Tampilkan & Aktif sudah dipakai untuk jadwal yudisium lain"]
                  ]);
          } else {
            
            $person2 = DB::table('jadwal_yudisium')->where('ID_JADWAL_YUDISIUM', $id)
                      ->update([
                      'ID_PERIODE_WISUDA' => $ID_PERIODE_WISUDA,
                      'YUDISIUM' => $YUDISIUM,
                      'TGL_YUDISIUM' => $TGL_YUDISIUM,
                      'STATUS_JADWAL_YUDISIUM' => $STATUS_JADWAL_YUDISIUM,
                      ]);

            $data = TabelPeriodeWisuda::where('ID_PERIODE_WISUDA', '=', ($ID_PERIODE_WISUDA))->get();
            foreach ($data as $dataa) {
              $data = $dataa->TGL_WISUDA;
            }
            $person2 = array(
            'TGL_WISUDA'      => $this->indonesiaDate($data),
            'YUDISIUM'          => $YUDISIUM,
            'TGL_YUDISIUM'          => $this->indonesiaDate($TGL_YUDISIUM),
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,
            'TampilkanAktif'          => $TampilkanAktif,

            );
            
            return response()->json([
                   'success'  => true,
                   'data' => $person2
                   ]);
          
          }
        
        }

        if ($STATUS_JADWAL_YUDISIUM == '1') {

            
            $person2 = DB::table('jadwal_yudisium')->where('ID_JADWAL_YUDISIUM', $id)
                      ->update([
                      'ID_PERIODE_WISUDA' => $ID_PERIODE_WISUDA,
                      'YUDISIUM' => $YUDISIUM,
                      'TGL_YUDISIUM' => $TGL_YUDISIUM,
                      'STATUS_JADWAL_YUDISIUM' => $STATUS_JADWAL_YUDISIUM,
                      ]);

            $data = TabelPeriodeWisuda::where('ID_PERIODE_WISUDA', '=', ($ID_PERIODE_WISUDA))->get();
            foreach ($data as $dataa) {
              $data = $dataa->TGL_WISUDA;
            }
            $person2 = array(
            'TGL_WISUDA'      => $this->indonesiaDate($data),
            'YUDISIUM'          => $YUDISIUM,
            'TGL_YUDISIUM'          => $this->indonesiaDate($TGL_YUDISIUM),
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,
            'TampilkanAktif'          => $TampilkanAktif,

            );
            
            return response()->json([
                   'success'  => true,
                   'data' => $person2
                   ]);
          
        
        }

        if ($STATUS_JADWAL_YUDISIUM == '0') {
            
            DB::table('wisudawan')->where('VERIFIKASI', '0')->delete();

            $person2 = DB::table('jadwal_yudisium')->where('ID_JADWAL_YUDISIUM', $id)
                      ->update([
                      'ID_PERIODE_WISUDA' => $ID_PERIODE_WISUDA,
                      'YUDISIUM' => $YUDISIUM,
                      'TGL_YUDISIUM' => $TGL_YUDISIUM,
                      'STATUS_JADWAL_YUDISIUM' => $STATUS_JADWAL_YUDISIUM,
                      ]);

            DB::table('file_yudisium')->where('ID_JADWAL_YUDISIUM', $id)
                      ->update([
                      'STATUS' => '2',
                      ]);

            $data = TabelPeriodeWisuda::where('ID_PERIODE_WISUDA', '=', ($ID_PERIODE_WISUDA))->get();
            foreach ($data as $dataa) {
              $data = $dataa->TGL_WISUDA;
            }
            $person2 = array(
            'TGL_WISUDA'      => $this->indonesiaDate($data),
            'YUDISIUM'          => $YUDISIUM,
            'TGL_YUDISIUM'          => $this->indonesiaDate($TGL_YUDISIUM),
            'Tampilkan'          => $Tampilkan,
            'Sembunyikan'          => $Sembunyikan,
            'TampilkanAktif'          => $TampilkanAktif,

            );
            
            return response()->json([
                   'success'  => true,
                   'data' => $person2
                   ]);
          
        
        }
        // $person2 = TabelJadwalYudisium::findOrFail($id);
        // $person2->update($request->all());
    }

    
    public function destroyJadwalyudisium($id)
    {
        TabelJadwalYudisium::destroy($id);
        return response()->json([
               'success' => true,
               ]);
    }

    public function fileyudisium($id)
    {
        $person3 = TabelFileYudisium::find($id);   
        return Response::json($person3);
    }

    public function storeFileyudisium(Request $request)
    {
      $ID_JADWAL_YUDISIUM     = Input::get('ID_JADWAL_YUDISIUM');
      $NAMA_FILE     = Input::get('NAMA_FILE');
      $INISIAL    = Input::get('INISIAL');
      $STATUS    = Input::get('STATUS');
      if ($STATUS == 1) {
        $Tampilkan    = 'Tampilkan';
        $Sembunyikan    = '';
      } if ($STATUS == 2) {
        $Tampilkan    = '';
        $Sembunyikan    = 'Sembunyikan';
      }

      $rules = array(
       'ID_JADWAL_YUDISIUM'   => 'required',
       'NAMA_FILE'   => 'required',
       'INISIAL'   => 'required',
       'INISIAL'       => array('required','max:10'),
       // 'INISIAL'       => array('required','unique:file_yudisium,INISIAL'),
       'STATUS'   => 'required',

       );
      $custom = array(
       'ID_JADWAL_YUDISIUM.required' => 'Tanggal Yudisium is required.',
       'NAMA_FILE.required' => 'Nama File is required.',
       'INISIAL.required' => 'Inisial File is required.',
       'INISIAL.max' => 'Inisial File max 10 characters.',
       // 'INISIAL.unique' => 'Inisial sudah dipakai oleh file lain.',
       'STATUS.required' => 'Status File is required.',
       );

      $validator = Validator::make(Input::all(), $rules, $custom);

      if($validator->fails())
      {
        return response()->json([
          'success' => false,
          'errors'   => $validator->errors()->toArray()
          ]);
      }

      $idFile = $this->getlastidFileyudisium();
      $value = 1;

      $person3 = DB::table('file_yudisium')->insert([
        'ID_FILE'      => ($idFile + $value),
        'ID_JADWAL_YUDISIUM'     => $ID_JADWAL_YUDISIUM,
        'NAMA_FILE'     => $NAMA_FILE,
        'INISIAL'   => $INISIAL,
        'STATUS'   => $STATUS,
      ]);

      $tglyudisium   = TabelJadwalYudisium::where('ID_JADWAL_YUDISIUM','=',$ID_JADWAL_YUDISIUM)->pluck('TGL_YUDISIUM');

      $person3 = array(
        'ID_JADWAL_YUDISIUM'      => $this->indonesiaDate($tglyudisium),
        'NAMA_FILE'      => $NAMA_FILE,
        'INISIAL'          => $INISIAL,
        'Tampilkan'          => $Tampilkan,
        'Sembunyikan'          => $Sembunyikan,
        );

          // $person3 = TabelFileYudisium::create($request->all());
      return response()->json([
       'success'  => true,
       'data' => $person3
       ]);

    }

    public function getlastidFileyudisium()
    {
        $data = DB::table('file_yudisium')->orderBy('ID_FILE', 'desc')->skip(0)->take(1)->get();
        foreach ($data as $data1) {
            return $data1->ID_FILE;
        }
    }

    public function updateFileyudisium(Request $request, $id)
    {
        $ID_JADWAL_YUDISIUM     = Input::get('ID_JADWAL_YUDISIUM');
        $NAMA_FILE     = Input::get('NAMA_FILE');
        $INISIAL    = Input::get('INISIAL');
        $STATUS    = Input::get('STATUS');

        if ($STATUS == 1) {
          $Tampilkan    = 'Tampilkan';
          $Sembunyikan    = '';
        } if ($STATUS == 2) {
          $Tampilkan    = '';
          $Sembunyikan    = 'Sembunyikan';
        }
       
       $rules = array(
                      'ID_JADWAL_YUDISIUM'   => 'required',
                      'NAMA_FILE'   => 'required',
                      'INISIAL'   => 'required',
                      // 'INISIAL'       => array('required','unique:file_yudisium,INISIAL'),
                       'STATUS'   => 'required',
                      );

        $custom = array(
                       'ID_JADWAL_YUDISIUM.required' => 'Tanggal Yudisium is required.',
                       'NAMA_FILE.required' => 'Nama File is required.',
                       'INISIAL.required' => 'Inisial File is required.',
                       'INISIAL.unique' => 'Inisial sudah dipakai oleh file lain.',
                       'STATUS.required' => 'Status File is required.',

                      );

        $validator = Validator::make(Input::all(), $rules, $custom);
 
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                // 'errors'   => $validator->errors()->toArray(),
                'errors'   =>$validator->errors(),
                ]);
        }

        // $person3 = TabelFileYudisium::findOrFail($id);
        // $person3->update($request->all());

        $person2 = DB::table('file_yudisium')->where('ID_FILE', $id)
                  ->update([
                  'ID_JADWAL_YUDISIUM' => $ID_JADWAL_YUDISIUM,
                  'NAMA_FILE' => $NAMA_FILE,
                  'INISIAL' => $INISIAL,
                  'STATUS' => $STATUS,
                  ]);

        $tglyudisium   = TabelJadwalYudisium::where('ID_JADWAL_YUDISIUM','=',$ID_JADWAL_YUDISIUM)->pluck('TGL_YUDISIUM');

        $person3 = array(
          'ID_JADWAL_YUDISIUM'      => $this->indonesiaDate($tglyudisium),
          'NAMA_FILE'      => $NAMA_FILE,
          'INISIAL'          => $INISIAL,
          'Tampilkan'          => $Tampilkan,
          'Sembunyikan'          => $Sembunyikan,
        );

        return response()->json([
               'success'  => true,
               'data' => $person3
               ]);
    }

    public function destroyFileyudisium($id)
    {
        TabelFileYudisium::destroy($id);
        return response()->json([
               'success' => true,
               ]);
    }

    public function exportExcel() {

      $idjabatan = Session::get('jabatan');
      $idperiodewisuda = Session::get('idperiodewisuda');

      if (Session::has('access') && $idjabatan == "4" && $idperiodewisuda == null) {

            $data = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                  ->where('wisudawan.VERIFIKASI_AK','=','1')
                  ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                  ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')
                  ->join('jadwal_yudisium','wisudawan.ID_JADWAL_YUDISIUM','=','jadwal_yudisium.ID_JADWAL_YUDISIUM')
                  ->join('periode_wisuda','jadwal_yudisium.ID_PERIODE_WISUDA','=','periode_wisuda.ID_PERIODE_WISUDA')
                  ->orderBy('TGL_LULUS', 'DESC')
                  ->select(DB::raw("NIM, NAMA, UNIT as PRODI, 
                    (CASE WHEN (JENIS_KELAMIN = 1) THEN 'Laki-laki' ELSE 'Perempuan' END) as JENIS_KELAMIN, 
                    TEMPAT_LAHIR, DATE_FORMAT(TANGGAL_LAHIR, '%d %M %Y') as TANGGAL_LAHIR, DATE_FORMAT(TGL_TERDAFTAR, '%d %M %Y') as TGL_TERDAFTAR, DATE_FORMAT(TGL_LULUS, '%d %M %Y') as TGL_LULUS, NO_IJAZAH, IPK, SKS, ELPT, SKP, BIDANG_ILMU, JUDUL_SKRIPSI, DOSEN_PEMBIMBING_1, DOSEN_PEMBIMBING_2, AGAMA, ALAMAT, TELPON, NAMA_ORTU, ALAMAT_ORTU, TELPON_ORTU, YUDISIUM, DATE_FORMAT(TGL_YUDISIUM, '%d %M %Y') as TGL_YUDISIUM, DATE_FORMAT(TGL_WISUDA, '%d %M %Y') as TGL_WISUDA
                    "))
                  ->get();

            // return $data;

            $date = date('Y-m-d');

            Excel::create('Data Wisudawan Akademik ('.$date.')', function($excel) use($data) {

                $excel->sheet('Sheetname', function($sheet) use($data) {
                    $sheet->fromArray($data);
                });

            })->export('xls');

        } else if (Session::has('access') && $idjabatan == "4" && $idperiodewisuda == 1) {

            $data = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                  ->where('wisudawan.VERIFIKASI_AK','=','1')
                  ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                  ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')
                  ->join('jadwal_yudisium','wisudawan.ID_JADWAL_YUDISIUM','=','jadwal_yudisium.ID_JADWAL_YUDISIUM')
                  ->join('periode_wisuda','jadwal_yudisium.ID_PERIODE_WISUDA','=','periode_wisuda.ID_PERIODE_WISUDA')
                  ->orderBy('TGL_LULUS', 'DESC')
                  ->select(DB::raw("NIM, NAMA, UNIT as PRODI, 
                    (CASE WHEN (JENIS_KELAMIN = 1) THEN 'Laki-laki' ELSE 'Perempuan' END) as JENIS_KELAMIN, 
                    TEMPAT_LAHIR, DATE_FORMAT(TANGGAL_LAHIR, '%d %M %Y') as TANGGAL_LAHIR, DATE_FORMAT(TGL_TERDAFTAR, '%d %M %Y') as TGL_TERDAFTAR, DATE_FORMAT(TGL_LULUS, '%d %M %Y') as TGL_LULUS, NO_IJAZAH, IPK, SKS, ELPT, SKP, BIDANG_ILMU, JUDUL_SKRIPSI, DOSEN_PEMBIMBING_1, DOSEN_PEMBIMBING_2, AGAMA, ALAMAT, TELPON, NAMA_ORTU, ALAMAT_ORTU, TELPON_ORTU, YUDISIUM, DATE_FORMAT(TGL_YUDISIUM, '%d %M %Y') as TGL_YUDISIUM, DATE_FORMAT(TGL_WISUDA, '%d %M %Y') as TGL_WISUDA
                    "))
                  ->get();

            // return $data;

            $date = date('Y-m-d');

            Excel::create('Data Wisudawan Akademik ('.$date.')', function($excel) use($data) {

                $excel->sheet('Sheetname', function($sheet) use($data) {
                    $sheet->fromArray($data);
                });

            })->export('xls');

        } else if (Session::has('access') && $idjabatan == "4" && $idperiodewisuda != 1 ) {

            $data = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                  ->where('wisudawan.VERIFIKASI_AK', '=', '1')
                  ->where('jadwal_yudisium.ID_PERIODE_WISUDA', '=', $idperiodewisuda)
                  ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                  ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')
                  ->join('jadwal_yudisium','wisudawan.ID_JADWAL_YUDISIUM','=','jadwal_yudisium.ID_JADWAL_YUDISIUM')
                  ->join('periode_wisuda','jadwal_yudisium.ID_PERIODE_WISUDA','=','periode_wisuda.ID_PERIODE_WISUDA')

                  ->orderBy('TGL_LULUS', 'DESC')
                  ->select(DB::raw("NIM, NAMA, UNIT as PRODI, 
                    (CASE WHEN (JENIS_KELAMIN = 1) THEN 'Laki-laki' ELSE 'Perempuan' END) as JENIS_KELAMIN, 
                    TEMPAT_LAHIR, DATE_FORMAT(TANGGAL_LAHIR, '%d %M %Y') as TANGGAL_LAHIR, DATE_FORMAT(TGL_TERDAFTAR, '%d %M %Y') as TGL_TERDAFTAR, DATE_FORMAT(TGL_LULUS, '%d %M %Y') as TGL_LULUS, NO_IJAZAH, IPK, SKS, ELPT, SKP, BIDANG_ILMU, JUDUL_SKRIPSI, DOSEN_PEMBIMBING_1, DOSEN_PEMBIMBING_2, AGAMA, ALAMAT, TELPON, NAMA_ORTU, ALAMAT_ORTU, TELPON_ORTU, YUDISIUM, DATE_FORMAT(TGL_YUDISIUM, '%d %M %Y') as TGL_YUDISIUM, DATE_FORMAT(TGL_WISUDA, '%d %M %Y') as TGL_WISUDA
                    "))
                  ->get();
            
            $tglwisuda = TabelPeriodeWisuda::where('ID_PERIODE_WISUDA','=',$idperiodewisuda)->pluck('TGL_WISUDA');

            $date = date('Y-m-d');

            Excel::create('Data Alumni Akademik Periode Wisuda '.$this->indonesiaDate($tglwisuda).' ('.$date.')', function($excel) use($data) {

                $excel->sheet('Sheetname', function($sheet) use($data) {
                    $sheet->fromArray($data);
                });

            })->export('xls');

        } else {
            return redirect('logout');
        }
    
    }


    public function profile()
    {
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "4") {

          $nip = Session::get('nip');
          $profile = TabelPegawai::join('user_account', 'pegawai.NIP', '=', 'user_account.NIP')->where('pegawai.NIP','=',$nip)->get();

          return View::make('akademik.profile', compact('profile'));

        }
        else if (Session::has('access') && $idjabatan == "2") {

          $nip = Session::get('nip');
          $profile = TabelPegawai::join('user_account', 'pegawai.NIP', '=', 'user_account.NIP')->where('pegawai.NIP','=',$nip)->get();

          return View::make('prodi.profile', compact('profile'));

        }
        else if (Session::has('access') && $idjabatan == "1") {

          $nip = Session::get('nip');
          $profile = TabelPegawai::join('user_account', 'pegawai.NIP', '=', 'user_account.NIP')->where('pegawai.NIP','=',$nip)->get();

          return View::make('ruangbaca.profile', compact('profile'));

        }
        else if (Session::has('access') && $idjabatan == "3") {

          $nip = Session::get('nip');
          $profile = TabelPegawai::join('user_account', 'pegawai.NIP', '=', 'user_account.NIP')->where('pegawai.NIP','=',$nip)->get();
          return View::make('kemahasiswaan.profile', compact('profile'));

        }
        else {
            return redirect('logout');
        }

    }
    public function ubahPassword(Request $request)
    {
      $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "1" || Session::has('access') && $idjabatan == "2" ||Session::has('access') && $idjabatan == "3" || Session::has('access') && $idjabatan == "4") {

          $nip = Session::get('nip');
          $profile = TabelPegawai::join('user_account', 'pegawai.NIP', '=', 'user_account.NIP')->where('pegawai.NIP','=',$nip)->get();

          foreach ($profile as $dataa) {
            $user = $dataa->USERNAME;
          }

          $data = TabelUserAccount::all();
          $PASSWORD               = Input::get('PASSWORD');
          $PASSWORD_BARU          = Input::get('PASSWORD_BARU');
          $PASSWORD_CONFIRMATION  = Input::get('PASSWORD_CONFIRMATION');

          $data = TabelUserAccount::all()->where('USERNAME', ($user))->where('PASSWORD', md5($PASSWORD));

          if ($data->count() > 0) {
            DB::table('user_account')->where('USERNAME', ($user))->update([
              'PASSWORD'     => md5($PASSWORD_BARU),
              ]);              
            return Redirect::back()->withInput()->with('success', '<strong>Success! </strong> Password berhasil diubah.');
          } else {
            return Redirect::back()->withInput()->with('warning', '<strong>Warning! </strong> Password Lama yang anda masukkan salah.');
          }
        } 
        else {
          return redirect('logout');  
        }
    }

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


    
    public function addAkun()
    {
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "4") {

        $jabatan = TabelJabatan::all();

        $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
        return View::make('akademik.tambahakun', compact('profile','jabatan'));
        } else {
            return redirect('logout');
        }
    }

    public function addAkunSave()
    {
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "4") {

          $nip              = Input::get('NIP');
          $nama             = Input::get('NAMA');
          $jabatan          = Input::get('ID_JABATAN');
          $unit             = Input::get('ID_UNIT');
          $username         = Input::get('USERNAME');
          $password         = Input::get('PASSWORD');
          $aktivasi         = Input::get('AKTIVASI');

          $cekpegawai =TabelPegawai::all()->where('NIP', ($nip));
          if ($cekpegawai->count() < 1) {
            $cekusername =TabelUserAccount::all()->where('USERNAME', ($username));
            if ($cekusername->count() < 1) {
              // return 'insert';
              $pegawai = DB::table('pegawai')->insert([
                'NIP'            => $nip,
                'ID_JABATAN'     => $jabatan,
                'ID_UNIT'        => $unit,
                'NAMA_PEGAWAI'   => $nama,
              ]);

              $user = DB::table('user_account')->insert([
                'USERNAME'   => $username,
                'NIP'        => $nip,
                'PASSWORD'   => md5($password),
                'AKTIVASI'   => $aktivasi,
              ]);

              return Redirect::to("tambahakun")->with('register_success', ' <b>Sukses! </b> Akun berhasil dibuat.');

            } else {
              return Redirect::to("tambahakun")->withInput()->with('register_warning', ' <b>Oops...! </b> Username sudah ada, silahkan buat username baru.');
            }
            
          } else {
             return Redirect::to("tambahakun")->withInput()->with('register_danger', ' <b>Oops...! </b> NIP sudah ada.');
          }
          

        } else {
            return redirect('logout');
        }
    }

    public function kelolaAkun()
    {
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "4") {

        $data = TabelUserAccount::join('pegawai', 'user_account.NIP', '=', 'pegawai.NIP')
              ->join('jabatan','pegawai.ID_JABATAN', '=', 'jabatan.ID_JABATAN')
              ->join('unit','pegawai.ID_UNIT', '=', 'unit.ID_UNIT')->get();

        $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
        return View::make('akademik.kelolaakun', compact('profile','jabatan', 'data'));
        } else {
            return redirect('logout');
        }
    }

    public function kelolaAkunedit($id)
    {
        // $person = TabelUserAccount::find($id);
        $person = TabelPegawai::join('user_account', 'pegawai.NIP', '=', 'user_account.NIP')
        ->join('jabatan','pegawai.ID_JABATAN', '=', 'jabatan.ID_JABATAN')
        ->join('unit','pegawai.ID_UNIT', '=', 'unit.ID_UNIT')
        ->find($id);
        // $person = TabelPegawai::where('pegawai.NIP', '=', $id)
        // ->join('user_account', 'pegawai.NIP', '=', 'user_account.NIP')
        // ->join('jabatan','pegawai.ID_JABATAN', '=', 'jabatan.ID_JABATAN')
        // ->join('unit','pegawai.ID_UNIT', '=', 'unit.ID_UNIT')
        // ->get();

        return Response::json($person);
    }

    public function kelolaAkunsave(Request $request, $id)
    {

      $NIP            = Input::get('NIP');
      $NAMA_PEGAWAI   = Input::get('NAMA_PEGAWAI');
      $UNIT           = Input::get('UNIT');
      $JABATAN        = Input::get('JABATAN');
      $USERNAME       = Input::get('USERNAME');
      $AKTIVASI       = Input::get('AKTIVASI');

      $rules  = array(
                     'AKTIVASI'   => 'required',
                    );

      $custom = array(
                     'AKTIVASI.required' => 'Aktivasi is required.',
                    );

      $validator = Validator::make(Input::all(), $rules, $custom);

      if($validator->fails())
      {
          return response()->json([
              'success' => false,
              // 'errors'   => $validator->errors()->toArray(),
              'errors'   =>$validator->errors(),
              ]);
      }

      // $person = TabelPegawai::join('user_account', 'pegawai.NIP', '=', 'user_account.NIP')
      //   ->join('jabatan','pegawai.ID_JABATAN', '=', 'jabatan.ID_JABATAN')
      //   ->join('unit','pegawai.ID_UNIT', '=', 'unit.ID_UNIT')
      //   ->findOrFail($id);

      $person = DB::table('user_account')->where('NIP', $NIP)
                  ->update([
                  'AKTIVASI' => $AKTIVASI,
                  ]);
      // $person->update($request->all());

      if ($AKTIVASI == '1') {
        $AKTIVASI1 = 'Aktif';
        $AKTIVASI0 = '';
      } else if ($AKTIVASI == '0') {
        $AKTIVASI1 = '';
        $AKTIVASI0 = 'Non Aktif';
      }
      
      $person = array(
                  'NIP'               => $NIP, 
                  'NAMA_PEGAWAI'      => $NAMA_PEGAWAI,
                  'UNIT'              => $UNIT,
                  'JABATAN'           => $JABATAN,
                  'USERNAME'          => $USERNAME,
                  'AKTIVASI1'          => $AKTIVASI1,
                  'AKTIVASI0'          => $AKTIVASI0,
                   );

      return response()->json([
             'success'  => true,
             'data' => $person
             ]);
    }

    public function ubahPasswordAkun()
    {
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "4") {

        $data = TabelUserAccount::join('pegawai', 'user_account.NIP', '=', 'pegawai.NIP')
              ->join('jabatan','pegawai.ID_JABATAN', '=', 'jabatan.ID_JABATAN')
              ->join('unit','pegawai.ID_UNIT', '=', 'unit.ID_UNIT')->get();

        $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
        return View::make('akademik.ubahpasswordakun', compact('profile','jabatan', 'data'));
        } else {
            return redirect('logout');
        }
    }

    public function ubahPasswordAkunsave(Request $request, $id)
    {

      $NIP            = Input::get('NIP');
      $NAMA_PEGAWAI   = Input::get('NAMA_PEGAWAI');
      $UNIT           = Input::get('UNIT');
      $JABATAN        = Input::get('JABATAN');
      $USERNAME       = Input::get('USERNAME');
      $PASSWORD_BARU       = Input::get('PASSWORD_BARU');
      $KONFIRMASI_PASSWORD_BARU       = Input::get('KONFIRMASI_PASSWORD_BARU');

      $rules  = array(
                     // 'PASSWORD_BARU'   => 'min:8|required|regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).+$/',
                     'PASSWORD_BARU'   => 'min:8|max:20|required|regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).+$/',
                     'KONFIRMASI_PASSWORD_BARU'   => 'required|same:PASSWORD_BARU',
                    );

      $custom = array(
                     'PASSWORD_BARU.required' => 'Password Baru is required.',
                     'PASSWORD_BARU.min' => 'Password Baru must contain at least 8 characters (max length is 20 characters), including UPPER/lowercase and numbers.',
                     'PASSWORD_BARU.max' => 'Password Baru must contain at least 8 characters (max length is 20 characters), including UPPER/lowercase and numbers.',
                     'PASSWORD_BARU.regex' => 'Password Baru must contain at least 8 characters (max length is 20 characters), including UPPER/lowercase and numbers.',
                     'KONFIRMASI_PASSWORD_BARU.required' => 'Konfirmasi Password Baru is required.',
                     'KONFIRMASI_PASSWORD_BARU.same' => 'Konfirmasi Password Baru does not match.',
                    );

      $validator = Validator::make(Input::all(), $rules, $custom);

      if($validator->fails())
      {
          return response()->json([
              'success' => false,
              // 'errors'   => $validator->errors()->toArray(),
              'errors'   =>$validator->errors(),
              ]);
      }

      $person = DB::table('user_account')->where('NIP', $NIP)
                  ->update([
                  'PASSWORD' => md5($PASSWORD_BARU),
                  ]);
      
      $person = array(
                  'NIP'               => $NIP, 
                  'NAMA_PEGAWAI'      => $NAMA_PEGAWAI,
                  'UNIT'              => $UNIT,
                  'JABATAN'           => $JABATAN,
                  'USERNAME'          => $USERNAME,
                   );

      return response()->json([
             'success'  => true,
             'data' => $person
             ]);
    }

    public function cloudstorage()
    {
        $nip = Session::get('nip');
        if (Session::has('access') && Session::get('nip') == $nip) {

            $cloudaktif = TabelCloudStorage::where('STATUS_CLOUD', '=', '1')->pluck('ID_CLOUD');
            $cloud = TabelCloudStorage::all();
            // $data = TabelCloudStorage::all();

            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();

            return View::make('akademik.penyimpananfile', compact('cloud', 'cloudaktif', 'profile'));

        } else {
            return redirect('logout');
        }

    }


    public function saveCloudStorage(Request $request)
    {
      $idcloud     = Input::get('ID_CLOUD');
      
      if ($idcloud == '1') {
        // return "Dropbox";
        DB::table('cloud_storage')->where('ID_CLOUD', '=', '1')
          ->update([
                'STATUS_CLOUD'               => '1',          
                ]);

        DB::table('cloud_storage')->where('ID_CLOUD', '=', '2')
          ->update([
                'STATUS_CLOUD'               => '0',          
                ]);
              
              return Redirect::to("/penyimpananfile")->with('register_success', ' <b>Success! </b> Dropbox dipilih sebagai penyimpanan file.');
      
      } else {
        // return 'Google';
        DB::table('cloud_storage')->where('ID_CLOUD', '=', '2')
          ->update([
                'STATUS_CLOUD'               => '1',          
                ]);

        DB::table('cloud_storage')->where('ID_CLOUD', '=', '1')
          ->update([
                'STATUS_CLOUD'               => '0',          
                ]);
              
              return Redirect::to("/penyimpananfile")->with('register_success', ' <b>Success! </b> Google Drive dipilih sebagai penyimpanan file.');
      }
        
    }

}