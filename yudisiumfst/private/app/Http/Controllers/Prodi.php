<?php
namespace App\Http\Controllers;
use Input, Validator, Response, Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\TabelWisudawan;
use App\TabelUnit;
use App\TabelJenis;
use App\TabelDetailVerifikasi;
use App\TabelFileYudisium;
use App\TabelDetailFile;
use App\TabelAgama;
use App\TabelPeriodeWisuda;
use App\TabelPegawai;
use App\TabelUserAccount;
use App\TabelCloudStorage;
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

use App\Make;
use App\TabelJadwalYudisium;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;

use Dropbox\Client;
use App\Repositories\DropboxStorageRepository;
use App\Repositories\Googl;
class Prodi extends Controller
{
    private $client;
    private $drive;

    public function __construct(Googl $googl)
    {
        $this->client = $googl->client();
        $this->client->setAccessToken(session('user.token'));
        $this->drive = $googl->drive($this->client);

    }

    public function listYudisium()
    {
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');
        $idunit = Session::get('idunit');

        if (Session::has('access') && $idjabatan == "2") {

            $person = TabelWisudawan::where('VERIFIKASI','=','0')
                ->whereNotNull('NAMA_ORTU')
                ->where('unit.ID_UNIT','=',$idunit)
                ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->get();

            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
            return View::make('prodi.approve', compact('person', 'profile'));

        } else {
            return redirect('logout');
        }

    }

    public function onprocess()
    {
        $idjabatan = Session::get('jabatan');
        $nip =Session::get('nip');

        if (Session::has('access') && $idjabatan == "2") {

            $idunit = Session::get('idunit');
            $person = TabelWisudawan::where('VERIFIKASI','=','1')
                ->where('VERIFIKASI_AK','=','0')
                ->where('wisudawan.ID_UNIT','=',$idunit)
                ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->get();

            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
            return View::make('prodi.onprocess_pendaftaran', compact('person', 'profile'));

        } else {
            return redirect('logout');
        }
    }

    public function edit($id)
    {
        $idjabatan = Session::get('jabatan');
        if (Session::has('access') && $idjabatan == "2") {
            $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                    ->find($id);   
            return Response::json($person);
        } else {
            return redirect('logout');
        }
    }

    public function datetime(){
        date_default_timezone_set('asia/jakarta');
        $datetime = date('Y-m-d H:i:sa');
        return $datetime;
    }

    public function approvePendaftaranLawas(Request $request, $id)
    {
        $idjabatan = Session::get('jabatan');
        
        if (Session::has('access') && $idjabatan == "2") {
            $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')->findOrFail($id);
            $person->update(['VERIFIKASI' => 1]);

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

    public function approvePendaftaran(Request $request, $id)
    {
        $idjabatan = Session::get('jabatan');
        
        if (Session::has('access') && $idjabatan == "2") {

            $id = $id;
            $angkatan = substr($id, 2, 2);

            $skp = TabelWisudawan::where('NIM', '=', $id)->pluck('SKP');
            $unit = TabelWisudawan::where('NIM', '=', $id)->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')->pluck('UNIT');
            
            $jenjang = substr($unit, 0, 2);
            
            if ($angkatan == "06" || $angkatan == "07" || $angkatan == "08" || $angkatan == "09" || $jenjang == "S2" || $jenjang == "S3") {
                
                // return 'langsung approve';
                $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')->findOrFail($id);
                $person->update(['VERIFIKASI' => 1]);

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

                $nim = $id;

                return Redirect::to("detail_mhs/{$nim}")->withInput()->with('register_success', ' <b>Success! </b> Approve pendaftaran berhasil.');
            
            } else {
                // return 'skp dulu';
                if ($skp == null) {
                    // return 'SKP blm di input';
                    $nim = $id;

                    return Redirect::to("detail_mhs/{$nim}")->withInput()->with('register_warning', ' <b>Warning! </b> SKP Mahasiswa belum diinput.');
                } else {

                    // return 'approve';
                    $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')->findOrFail($id);
                    $person->update(['VERIFIKASI' => 1]);

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

                    $nim = $id;

                    return Redirect::to("detail_mhs/{$nim}")->withInput()->with('register_success', ' <b>Success! </b> Approve pendaftaran berhasil.');
                }
                
            }

        } else {
            return redirect('logout');
        }
    }

    public function cancelPendaftaran($id)
    {
        $idjabatan = Session::get('jabatan');
        
        if (Session::has('access') && $idjabatan == "2") {
                
            DB::table('detail_file')->where('NIM', $id)->delete();
            DB::table('wisudawan')->where('NIM', $id)->delete();

            return Redirect::to("approve")->withInput()->with('register_success', ' <b>Success! </b> Cancel pendaftaran berhasil.');
        } else {
            return redirect('logout');
        }
    }

    public function disapprovePendaftaran(Request $request, $id)
    {
        $idjabatan = Session::get('jabatan');
        
        if (Session::has('access') && $idjabatan == "2") {
            $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')->findOrFail($id);
            $person->update(['VERIFIKASI' => 0]);

            $nip        = Session::get('nip');
            $username   = TabelUserAccount::where('NIP','=',$nip)->pluck('USERNAME');


            $tglverifikasi = DB::Table('detail_verifikasi','user_account', 'pegawai', 'jabatan')
                ->where('detail_verifikasi.NIM','=',$id)
                ->where('pegawai.ID_JABATAN','=', '2')
                ->join('user_account','detail_verifikasi.USERNAME','=','user_account.USERNAME')
                ->join('pegawai','user_account.NIP','=','pegawai.NIP')
                ->get();
            foreach ($tglverifikasi as $data) {
                $userapprove =$data->USERNAME;
            }

            $cekverifikasi = TabelDetailVerifikasi::where('NIM', '=', $id)->where('USERNAME', '=', $userapprove)->get();

            if ($cekverifikasi->count() > 0) {
                DB::table('detail_verifikasi')->where('NIM', $id)->where('USERNAME', $userapprove)->delete();
            }

            // return response()->json([
            //        'success'  => true,
            //        'data' => $person
            //        ]);

            return Redirect::to("onprocess")->withInput()->with('register_success', ' <b>Success! </b> Disapprove pendaftaran berhasil.');
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
                }

                return View::make('prodi.detail_mhs', compact('data', 'profile', 'data2', 'verifikasi'));
        
        } else {
            return redirect('logout');
        }
    }

    public function detailMahasiswaOnproccess($nim) 
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

                $tglverifikasi = DB::Table('detail_verifikasi','user_account', 'pegawai', 'jabatan')
                ->where('detail_verifikasi.NIM','=',$nim)
                ->where('pegawai.ID_JABATAN','=', '2')
                ->join('user_account','detail_verifikasi.USERNAME','=','user_account.USERNAME')
                ->join('pegawai','user_account.NIP','=','pegawai.NIP')
                // ->select(DB::raw("DATE_FORMAT(TGL_DETAIL_VERIFIKASI, '%m %d %Y %h:%i:%s') as TGL_DETAIL_VERIFIKASI"))
                ->get();

                date_default_timezone_set('asia/jakarta');
                $date = date('Y-m-d H:i:s');

                return View::make('prodi.detail_mhs_onprocess', compact('data', 'profile', 'data2', 'verifikasi', 'nim', 'tglverifikasi', 'date'));
        
        } else {
            return redirect('logout');
        }
    }

    public function detailMahasiswaWisudawan($nim) 
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

                return View::make('prodi.detail_mhs_wisudawan', compact('data', 'profile', 'data2', 'verifikasi', 'nim'));
        
        } else {
            return redirect('logout');
        }
    }

    public function cancellawas($id)
    {
        $idjabatan = Session::get('jabatan');
        
        if (Session::has('access') && $idjabatan == "2") {
            DB::table('wisudawan')->where('NIM', $id)
              ->update([
                    'PASSWORD_TEMP'      => null,
                    'JENIS_KELAMIN'      => null,
                    'TGL_TERDAFTAR'      => null,
                    'TGL_LULUS'          => null,
                    'IPK'                => null,
                    'ELPT'               => null,
                    'BIDANG_ILMU'        => null,
                    'JUDUL_SKRIPSI'      => null,
                    'DOSEN_PEMBIMBING_1' => null,
                    'DOSEN_PEMBIMBING_2' => null,
                    'TEMPAT_LAHIR'       => null,
                    'TANGGAL_LAHIR'      => null,
                    'ALAMAT'             => null,
                    'TELPON'             => null,
                    'NAMA_ORTU'          => null,
                    'ALAMAT_ORTU'        => null,
                    'TELPON_ORTU'        => null,
                    'VERIFIKASI'         => null,
                    'VERIFIKASI_AK'      => null,
                    // 'VERIFIKASI_KM'      => null,
                    'TGL_DAFTAR_YUDISIUM'=> null,           
                    ]);

            return response()->json([
                   'success' => true,
                   ]);
        } else {
            return redirect('logout');
        }
    }

    public function dataWisudawan() 
    {

        $idjabatan = Session::get('jabatan');
        
        if (Session::has('access') && $idjabatan == "2") {

            $idunit = Session::get('idunit');
            $person = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
            ->where('wisudawan.VERIFIKASI_AK','=','1')
            ->where('wisudawan.ID_UNIT','=',$idunit)
            ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
            ->get();

            $pw = TabelPeriodeWisuda::orderBy('ID_PERIODE_WISUDA', 'DESC')->get();    

            $nip = Session::get('nip');

            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
            return View::make('prodi.data_alumni', compact('person', 'pw', 'profile'));

        } else {
            return redirect('logout');
        }
    }

    public function dataWisudawanPeriodeWisuda($id) 
    {

        $idjabatan = Session::get('jabatan');
        
        if (Session::has('access') && $idjabatan == "2") {

            if ($id == 1) {

                $idunit = Session::get('idunit');
                $person = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                ->where('wisudawan.VERIFIKASI_AK','=','1')
                ->where('wisudawan.ID_UNIT','=',$idunit)
                ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->get();

                $idperiodewisuda = 1;
                Session::put('idperiodewisuda', $idperiodewisuda);

                $pw = TabelPeriodeWisuda::all();

                $nip = Session::get('nip');

                $profile = TabelPegawai::where('NIP','=',$nip)
                ->get();
                return View::make('prodi.detailsalumni', compact('person', 'idperiodewisuda', 'pw', 'profile'));

              } else if ($id != 1) {

                $idunit = Session::get('idunit');
                $person = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                ->where('wisudawan.VERIFIKASI_AK','=','1')
                ->where('wisudawan.ID_UNIT','=',$idunit)
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

                $profile = TabelPegawai::where('NIP','=',$nip)
                ->get();
                return View::make('prodi.detailsalumni', compact('person', 'idperiodewisuda', 'pw', 'profile'));

              }

        } else {
            return redirect('logout');
        }
    }

     public function exportExcel()
     {
        $idjabatan = Session::get('jabatan');
        $idperiodewisuda = Session::get('idperiodewisuda');

        if (Session::has('access') && $idjabatan == "2" && $idperiodewisuda == null) {

            $idunit = Session::get('idunit');
            $data = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                  ->where('wisudawan.VERIFIKASI_AK','=','1')
                  ->where('wisudawan.ID_UNIT','=',$idunit)
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
                  // ->get(['NIM','NAMA','UNIT as PRODI','JENIS_KELAMIN','TEMPAT_LAHIR','TANGGAL_LAHIR','TGL_TERDAFTAR','TGL_LULUS','NO_IJAZAH','IPK','SKS','ELPT','SKP','BIDANG_ILMU','JUDUL_SKRIPSI','DOSEN_PEMBIMBING_1','DOSEN_PEMBIMBING_2','AGAMA','ALAMAT','TELPON','NAMA_ORTU','ALAMAT_ORTU','TELPON_ORTU']);
            
            $date = date('Y-m-d');
            $prodi = DB::table('unit')->where('ID_UNIT',$idunit)->first();

            Excel::create('Data Wisudawan '.$prodi->UNIT.' ('.$date.')', function($excel) use($data) {

                $excel->sheet('Sheetname', function($sheet) use($data) {
                    $sheet->fromArray($data);
                });

            })->export('xls');

       } else if (Session::has('access') && $idjabatan == "2" && $idperiodewisuda == 1) {

            $idunit = Session::get('idunit');
            $data = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                  ->where('wisudawan.VERIFIKASI_AK','=','1')
                  ->where('wisudawan.ID_UNIT','=',$idunit)
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

            $date = date('Y-m-d');
            $prodi = DB::table('unit')->where('ID_UNIT',$idunit)->first();

            Excel::create('Data Wisudawan '.$prodi->UNIT.' ('.$date.')', function($excel) use($data) {

                $excel->sheet('Sheetname', function($sheet) use($data) {
                    $sheet->fromArray($data);
                });

            })->export('xls');

        } else if (Session::has('access') && $idjabatan == "2" && $idperiodewisuda != 1 ) {

            $idunit = Session::get('idunit');
            $data = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                  ->where('wisudawan.VERIFIKASI_AK','=','1')
                  ->where('wisudawan.ID_UNIT','=',$idunit)
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
            $prodi = DB::table('unit')->where('ID_UNIT',$idunit)->first();

            Excel::create('Data Wisudawan '.$prodi->UNIT.' Periode Wisuda '.$this->indonesiaDate($tglwisuda).' ('.$date.')', function($excel) use($data) {

                $excel->sheet('Sheetname', function($sheet) use($data) {
                    $sheet->fromArray($data);
                });

            })->export('xls');

        } else {
            return redirect('logout');
        }
    
    }

    public function exportExcelOnProcess() {

        $idjabatan = Session::get('jabatan');
      if (Session::has('access') && $idjabatan == "2") {

            $idunit = Session::get('idunit');
            $data = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
                  ->where('wisudawan.VERIFIKASI_AK','=','0')
                  ->where('wisudawan.ID_UNIT','=',$idunit)
                  ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                  ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')
                  ->orderBy('TGL_LULUS', 'DESC')
                  ->select(DB::raw("NIM, NAMA, UNIT as PRODI, 
                    (CASE WHEN (JENIS_KELAMIN = 1) THEN 'Laki-laki' ELSE 'Perempuan' END) as JENIS_KELAMIN, 
                    TEMPAT_LAHIR, DATE_FORMAT(TANGGAL_LAHIR, '%d %M %Y') as TANGGAL_LAHIR, DATE_FORMAT(TGL_TERDAFTAR, '%d %M %Y') as TGL_TERDAFTAR, DATE_FORMAT(TGL_LULUS, '%d %M %Y') as TGL_LULUS, NO_IJAZAH, IPK, SKS, ELPT, SKP, BIDANG_ILMU, JUDUL_SKRIPSI, DOSEN_PEMBIMBING_1, DOSEN_PEMBIMBING_2, AGAMA, ALAMAT, TELPON, NAMA_ORTU, ALAMAT_ORTU, TELPON_ORTU
                    "))
                  ->get();
                  // ->get(['NIM','NAMA','UNIT as PRODI','JENIS_KELAMIN','TEMPAT_LAHIR','TANGGAL_LAHIR','TGL_TERDAFTAR','TGL_LULUS','NO_IJAZAH','IPK','SKS','ELPT','SKP','BIDANG_ILMU','JUDUL_SKRIPSI','DOSEN_PEMBIMBING_1','DOSEN_PEMBIMBING_2','AGAMA','ALAMAT','TELPON','NAMA_ORTU','ALAMAT_ORTU','TELPON_ORTU']);
            
            $date = date('Y-m-d');
            $prodi = DB::table('unit')->where('ID_UNIT',$idunit)->first();

            Excel::create('Data Pendaftar Yudisium '.$prodi->UNIT.' '.$date.'', function($excel) use($data) {

                $excel->sheet('Sheetname', function($sheet) use($data) {

                    $sheet->fromArray($data);

                });

            })->export('xls');

        } else {
            return redirect('logout');
        }
    
    }

    public function cetakSurat()
    {
        if (Session::has('access') && Session::get('level')==2) {

        $id = Session::get('id');
        $idprodi = Session::get('prodi');

        $profile = TabelUserAccount::where('user_account.ID_AKUN','=',$id)
            ->get();
        return View::make('prodi.cetaksurat', compact('profile','idprodi'));
        } else {
            return redirect('logout');
        }
    }

    public function postCetakSurat() {

        if (Session::has('access') && Session::get('level')==2) {
            date_default_timezone_set('asia/jakarta');
            $date = date('Y-m-d');
            // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
            $BulanIndo = array("Januari", "Februari", "Maret",
                               "April", "Mei", "Juni",
                               "Juli", "Agustus", "September",
                               "Oktober", "November", "Desember");

            $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
            $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
            $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
            
            $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;

            $NIM = Input::get('NIM');
            $NAMA = Input::get('NAMA');
            $ID_PRODI = Session::get('prodi');

            $PRODI  = TabelProdi::where('prodi.ID_PRODI','=',$ID_PRODI)
                    ->pluck('PRODI');
            $PRODI_UP = strtoupper($PRODI);

            $DEPARTEMEN = TabelProdi::where('prodi.ID_PRODI','=',$ID_PRODI)
                        ->join('departemen','prodi.ID_DEPARTEMEN','=','departemen.ID_DEPARTEMEN')
                        ->pluck('DEPARTEMEN');
            $DEPARTEMEN_UP = strtoupper($DEPARTEMEN);

            $JENJANG = TabelProdi::where('prodi.ID_PRODI','=',$ID_PRODI)
                        ->join('jenjang','prodi.ID_JENJANG','=','jenjang.ID_JENJANG')
                        ->pluck('JENJANG');
        
            $TANGGAL_UJIAN = Input::get('TANGGAL_UJIAN');
            // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
            $BulanIndo = array("Januari", "Februari", "Maret",
                               "April", "Mei", "Juni",
                               "Juli", "Agustus", "September",
                               "Oktober", "November", "Desember");

            $tahun = substr($TANGGAL_UJIAN, 0, 4); // memisahkan format tahun menggunakan substring
            $bulan = substr($TANGGAL_UJIAN, 5, 2); // memisahkan format bulan menggunakan substring
            $tgl   = substr($TANGGAL_UJIAN, 8, 2); // memisahkan format tanggal menggunakan substring

            $TANGGAL_UJIAN_BARU = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;

            $pdf = \App::make('dompdf.wrapper');

            $html = '<html>
            <head>
                <title></title>
            </head>
            <body>

                <table width="100%">
                    <tr>
                        <td width="10" align="center"><img src="private/unair.gif" width="100" height="100"></td>
                        <td width="" align="center"><font size="3" ><b>UNIVERSITAS AIRLANGGA<br></font>
                            <font size="3" ><b>FAKULTAS SAINS DAN TEKNOLOGI<br>
                            <b>DEPARTEMEN '.$DEPARTEMEN_UP.'<br>
                            <b>'.$PRODI_UP.'<br></font>
                            <font size="1" >Kampus C Jl. Mulyorejo Surabaya (60115) Telephone (031) 5936501, 5924614 Fax (031) 5936502<br>Website : http//www.fst.unair.ac.id – E-mail : fst@unair.ac.id</font>
                        </td>
                        <td width="8" align="center" ><img src="private/blank.png" width="100" height="100"></td>
                    </tr>
                </table>
                <img src="private/garis.png" align="center" width="704" height="">
                <br style="line-height:1.5;">
                <table width="100%">
                    <tr>
                        <td width="" align="center"><font size="3" ><b>BEBAS PEMINJAMAN ALAT DAN BUKU<br></font>
                        </td>
                    </tr>
                </table>
                <br><br>
                <table width="100%">
                    <tr>
                        <td width="2" align="left">
                        </td>
                        <td width="96" align="left">
                            <font size="3" >Bertanda tangan dibawah ini, kami menyatakan bahwa : <br></font>
                            <br>
                            <table width="100%">
                                <tr>
                                    <td align="left"><font size="3" >NAMA</font></td>
                                    <td align="left"><font size="3" >:</font>
                                    </td>
                                    <td align="left"><font size="3" ><b> '.$NAMA.'  </font></td>
                                </tr>
                                <tr>
                                    <td width="4" align="left"><font size="3" >NIM</font></td>
                                    <td width="1" align="left"><font size="3" >:</font>
                                    </td>
                                    <td width="95" align="left" ><font size="3" ><b> '.$NIM.' </font></td>
                                </tr>
                                <tr>
                                    <td width="4" align="left"><font size="3" >Prodi</font></td>
                                    <td width="1" align="left"><font size="3" >:</font>
                                    </td>
                                    <td width="95" align="left" ><font size="3" ><b> '.$PRODI.' </font></td>
                                </tr>
                                <tr>
                                    <td width="4" align="left"><font size="3" >Tanggal Ujian</font></td>
                                    <td width="1" align="left"><font size="3" >:</font>
                                    </td>
                                    <td width="95" align="left" ><font size="3" ><b> '.$TANGGAL_UJIAN_BARU.' </font></td>
                                </tr>
                            </table>
                            <br>
                            <p style="text-align: justify; line-height:1.5;" >
                            <font size="3" >Sudah tidak mempunyai tanggungan peminjaman/ penggantian peralatan laboratorium, maupun buku/ jurnal/ majalah milik Universitas Airlangga. Surat keterangan ini untuk digunakan sebagai kelengkapan persyaratan lulus Program '.$JENJANG.' di Fakultas Sains Teknologi Universitas Airlangga.<br></font></p>  
                        </td>
                        <td width="2" align="left">
                        </td>
                    </tr>
                </table>

                <table width="100%">
                    <tr>
                        <td width="2" align="left">
                        </td>
                        <td width="96" align="right">
                            <p style="text-align: right; line-height:1.5;" >
                            <font size="3" >Surabaya, '.$result.'<br></font></p>
                        </td>
                        <td width="2" align="left">
                        </td>
                    </tr>
                </table>

                <table width="100%">
                    <tr>
                        <td width="2" align="left">
                        </td>
                        <td width="48" align="left">
                            <p style="text-align: justify; line-height:100%;" >
                            <font size="3" >Petugas Laboratorium<br>Departemen '.$DEPARTEMEN.' FSaintek Unair</font></p>
                            <br>
                            <br>
                            <P style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                            <p style="text-align: justify; line-height:0%;" >
                            <font size="3" >NIP.</font></p>
                        </td>
                        <td width="2" align="left">
                        </td>
                        <td width="48" align="left">
                            <p style="text-align: justify; line-height:100%;" >
                            <font size="3" >Petugas Perpustakaan<br>Departemen '.$DEPARTEMEN.' FSaintek Unair</font></p>
                            <br>
                            <br>
                            <P style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                            <p style="text-align: justify; line-height:0%;" >
                            <font size="3" >NIP.</font></p>
                        </td>
                    </tr>
                </table>
                <br>
                <table width="100%">
                    <tr>
                        <td width="26" align="center">
                        </td>
                        <td width="48" align="center">
                            <p style="text-align: center; line-height:100%; align="center";" >
                            <font size="3" >Petugas Perpustakaan<br>FSaintek Unair</font></p>
                            <br>
                            <br>
                            <p style="text-align: center; text-decoration:underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                            <p style="text-align: left; line-height:0%;" >
                            <font size="3" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NIP.</font></p>
                        </td>
                        <td width="26" align="center">
                        </td>
                    </tr>
                </table>

            </body>
            </html>';

            $pdf->loadHTML($html);
       
            return $pdf->stream('Surat Keterangan Bebas Pinjam Alat - '.$NIM);
        
        } else {
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

    public function cetakForm(){
 
        $idmhs = Session::get('$idmhs');
 
        date_default_timezone_set('asia/jakarta');
        $date = date('Y-m-d');
        // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
        $BulanIndo = array("Januari", "Februari", "Maret",
                           "April", "Mei", "Juni",
                           "Juli", "Agustus", "September",
                           "Oktober", "November", "Desember");

        $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
        $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
        $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring


        $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
        $data = DB::Table('alumni','prodi','agama','jenis_kelamin','ortu_alumni')
                    ->where('alumni.NIM','=',$idmhs)
                    ->join('prodi','alumni.ID_PRODI','=','prodi.ID_PRODI')
                    ->join('agama','alumni.ID_AGAMA','=','agama.ID_AGAMA')
                    ->join('jenis_kelamin','alumni.ID_JENIS_KELAMIN','=','jenis_kelamin.ID_JENIS_KELAMIN')
                    ->join('ortu_alumni','alumni.NIM','=','ortu_alumni.NIM')
                    ->get();

        foreach ($data as $dataa) {
            # code...
            $NIM = $dataa->NIM;
            $NAMA = $dataa->NAMA;
            $PRODI = $dataa->PRODI;
            $TGL_TERDAFTAR = $this->indonesiaDate($dataa->TGL_TERDAFTAR);
            $TGL_LULUS = $this->indonesiaDate($dataa->TGL_LULUS);
            $NO_IJAZAH = $dataa->NO_IJAZAH;
            $IPK = $dataa->IPK;
            $ELPT = $dataa->ELPT;
            $SKP = $dataa->SKP;
            $BIDANG_ILMU = $dataa->BIDANG_ILMU;
            $JUDUL_SKRIPSI = $dataa->JUDUL_SKRIPSI;
            $DOSEN_PEMBIMBING_1 = $dataa->DOSEN_PEMBIMBING_1;
            $DOSEN_PEMBIMBING_2 = $dataa->DOSEN_PEMBIMBING_2;
            $TEMPAT_LAHIR = $dataa->TEMPAT_LAHIR;
            $TANGGAL_LAHIR = $this->indonesiaDate($dataa->TANGGAL_LAHIR);
            $AGAMA = $dataa->AGAMA;
            $JENIS_KELAMIN = $dataa->JENIS_KELAMIN;
            $ALAMAT = $dataa->ALAMAT;
            $TELPON = $dataa->TELPON;
            $NAMA_ORTU = $dataa->NAMA_ORTU;
            $ALAMAT_ORTU = $dataa->ALAMAT_ORTU;
            $TELPON_ORTU = $dataa->TELPON_ORTU;
        }

        $pdf = \App::make('dompdf.wrapper');

// . td {
//                 text-indent: 0.4em;
//             }

        $html = '<html>
        <head>
        <style type="text/css">
            .table, td, th {
                border: 1px solid black;
            }
            .table {
                border-collapse:collapse;
                width:100%;
            }
            .th, td {
                padding: 4px;
                text-align: left;
                text-indent: 0.4em;
            }
        </style>
            <title></title>
        </head>
        <body>
            <table width="100%" border="0">
                <tr>
                    <td width="1"></td>
                    <td width="98" align="center"><font size="4" ><b>FORMULIR DATA LULUSAN UNIVERSITAS AIRLANGGA<br></font>
                        <font size="4" ><b>Untuk Wisuda dan Cetak Ijasah<br>
                    </td>
                    <td width="1"></td>
                </tr>
            </table>

            <br>


            <table width="100%" cellspacing="0">
                <tr >
                    <td width="36%"> Nim </td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$NIM.'</td>
                </tr>
                <tr >
                    <td width="36%"> Nama </td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$NAMA.'</td>
                </tr>
                <tr >
                    <td width="36%"> Fakultas</td>
                    <td width="2%"> : </td>
                    <td width="62%"> Sains dan Teknologi</td>
                </tr>
                <tr >
                    <td width="36%"> Program Studi</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$PRODI.'</td>
                </tr>
                <tr >
                    <td width="36%"> Tgl. Terdaftar Di Unair</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$TGL_TERDAFTAR.'</td>
                </tr>
                <tr >
                    <td width="36%"> Status Mahasiswa</td>
                    <td width="2%"> : </td>
                    <td width="62%"> <img src="private/a.png" width="20" height="20"> Ikut Wisuda</td>
                </tr>
                <tr >
                    <td width="36%" rowspan="2"> </td>
                    <td width="2%"> </td>
                    <td width="62%"> <img src="private/a.png" width="20" height="20"> Cetak Ijasah</td>
                </tr>
                <tr >
                    <td width="2%"> </td>
                    <td width="62%" size="1"> <img src="private/a blank.png" width="20" height="20"> Melanjutkan Profesi (Khusus untuk FK, FKG, FE-akuntansi, FF, FKH, Fpsi)</td>
                </tr>
                <tr >
                    <td width="36%"> Tanggal Lulus</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$TGL_LULUS.'</td>
                </tr>
                <tr >
                    <td width="36%"> No. Urut Ijasah</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$NO_IJAZAH.'</td>
                </tr>
                <tr >
                    <td width="36%"> IPK</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$IPK.'</td>
                </tr>
                <tr >
                    <td width="36%"> Skor TOEFL</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$ELPT.'</td>
                </tr>
                <tr >
                    <td width="36%"> Bidang Ilmu</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$BIDANG_ILMU.'</td>
                </tr>
                <tr >
                    <td width="36%"> Judul Skripsi/Tesis/Desertasi</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$JUDUL_SKRIPSI.'</td>
                </tr>
                <tr >
                    <td width="36%"> Dosen Pembimbing 1</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$DOSEN_PEMBIMBING_1.'</td>
                </tr>
                <tr >
                    <td width="36%"> Dosen Pembimbing 2</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$DOSEN_PEMBIMBING_2.'</td>
                </tr>
                <tr >
                    <td width="36%"> Tempat, Tanggal Lahir</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$TEMPAT_LAHIR.', '.$TANGGAL_LAHIR.'</td>
                </tr>
                <tr >
                    <td width="36%"> Agama</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$AGAMA.'</td>
                </tr>
                <tr >
                    <td width="36%"> Jenis Kelamin</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$JENIS_KELAMIN.'</td>
                </tr>
                <tr >
                    <td width="36%"> Alamat Tinggal Mahasiswa</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$ALAMAT.'</td>
                </tr>
                <tr >
                    <td width="36%"> Telpon/Handphone Mahasiswa</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$TELPON.'</td>
                </tr>
                <tr >
                    <td width="36%"> </td>
                    <td width="2%"> </td>
                    <td width="62%"> </td>
                </tr>
                <tr >
                    <td width="36%"> Nama Orang Tua</td>
                    <td width="2%"> : </td>
                    <td width="62%" > '.$NAMA_ORTU.'</td>
                </tr>
                <tr >
                    <td width="36%"> Alamat Tinggal Orang Tua</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$ALAMAT_ORTU.'</td>
                </tr>
                <tr >
                    <td width="36%"> Telpon/Handphone Orang Tua</td>
                    <td width="2%"> : </td>
                    <td width="62%"> '.$TELPON_ORTU.'</td>
                </tr>
            </table>

            <table width="100%" border="0">
                <tr>
                    <td width="2" align="left">
                    </td>
                    <td width="28" align="center">
                        <table>
                            <tr>
                                <td align="center"><font size="2">Foto dilakukan di <br> Gedung Rektorat <br> Lt.1 bagian <br> Registrasi <br> Direktorat <br> Pendidikan</font>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="20" align="left">

                    <td width="2" align="left">
                    </td>
                    <td width="48" align="left">
                        <p style="text-align: justify; line-height:100%;" >
                        <font size="3" >Surabaya, '.$result.'</font></p>
                        <br>
                        <br>
                        <P style="text-decoration:underline;"> '.$NAMA.' </p>
                        <p style="text-align: justify; line-height:0%;" >
                        <font size="1" >Tanda tangan dan nama lengkap</font></p>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0">
                <tr>
                    <td align="left"><font size="1" >
                    NB : Formulir Kelulusan Wajib Melampirkan Fotocopy TOEFL</td>
                </tr>
            </table>
        </body>
        </html>';

        $pdf->loadHTML($html);
        return $pdf->stream();
        }



    public function ubahPasswordAkun()
    {
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');
        $idunit = Session::get('idunit');

        if (Session::has('access') && $idjabatan == "2") {

        $data = TabelWisudawan::where('VERIFIKASI_AK','=','0')
                ->whereNotNull('NAMA_ORTU')
                ->where('unit.ID_UNIT','=',$idunit)
                ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->get();


        $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
        return View::make('prodi.ubahpasswordakun', compact('profile','jabatan', 'data'));
        } else {
            return redirect('logout');
        }
    }

    public function ubahPasswordAkunsave(Request $request, $id)
    {

      $NIM              = Input::get('NIM');
      $NAMA             = Input::get('NAMA');
      $UNIT             = Input::get('UNIT');
      $JENIS_KELAMIN    = Input::get('JENIS_KELAMIN');
      $TELPON           = Input::get('TELPON');
      $PASSWORD_BARU    = Input::get('PASSWORD_BARU');
      $KONFIRMASI_PASSWORD_BARU       = Input::get('KONFIRMASI_PASSWORD_BARU');

      $rules  = array(
                     // 'PASSWORD_BARU'   => 'min:8|required|regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).+$/',
                     'PASSWORD_BARU'   => 'min:8|max:8|required|regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).+$/',
                     'KONFIRMASI_PASSWORD_BARU'   => 'required|same:PASSWORD_BARU',
                    );

      $custom = array(
                     'PASSWORD_BARU.required' => 'Password Baru is required.',
                     'PASSWORD_BARU.min' => 'Password Baru must contain at least 8 characters (max length is 8 characters), including UPPER/lowercase and numbers.',
                     'PASSWORD_BARU.max' => 'Password Baru must contain at least 8 characters (max length is 8 characters), including UPPER/lowercase and numbers.',
                     'PASSWORD_BARU.regex' => 'Password Baru must contain at least 8 characters (max length is 8 characters), including UPPER/lowercase and numbers.',
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

      $person = DB::table('wisudawan')->where('NIM', $NIM)
                  ->update([
                  'PASSWORD_TEMP' => $PASSWORD_BARU,
                  ]);

        if ($JENIS_KELAMIN == '1') {
            $JENIS_KELAMIN = 'Laki-laki';
        } else if ($JENIS_KELAMIN == '2'){
            $JENIS_KELAMIN = 'Perempuan';
        }
        
      
      $person = array(
                  'NIM'                 => $NIM, 
                  'NAMA'                => $NAMA,
                  'UNIT'                => $UNIT,
                  'JENIS_KELAMIN'       => $JENIS_KELAMIN,
                  'TELPON'              => $TELPON,
                   );

      return response()->json([
             'success'  => true,
             'data' => $person
             ]);
    }

    public function pesan($nim, $idfile)
    {
        
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');
        $idunit = Session::get('idunit');

        if (Session::has('access') && $idjabatan == "2") {

            $data = TabelDetailFile::where('ID_FILE','=',$idfile)->where('NIM','=',$nim)->get();
            $namamhs = TabelWisudawan::where('NIM', '=', $nim)->pluck('NAMA');
    
            $profile = TabelPegawai::where('NIP','=',$nip)->get();

            return View::make('prodi.pesan', compact('data', 'namamhs', 'profile'));

        } else {
            return redirect('logout');
        }

    }

    public function pesanPost($nim, $idfile)
    {
        
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');
        $idunit = Session::get('idunit');

        if (Session::has('access') && $idjabatan == "2") {

            $nim              = Input::get('NIM');
            $idfile           = Input::get('ID_FILE');
            $pesan            = Input::get('PESAN');

            DB::table('detail_file')->where('NIM', $nim)->where('ID_FILE', $idfile)
            ->update([
                'PESAN'               => $pesan,      
                ]);
              
            return Redirect::to("detail_mhs/".$nim."")->with('register_success', ' <b>Pesan berhasil dikirim! </b>');
            // $data = TabelDetailFile::where('ID_FILE','=',$idfile)->where('NIM','=',$nim)->get();
            // $namamhs = TabelWisudawan::where('NIM', '=', $nim)->pluck('NAMA');
    
            // $profile = TabelPegawai::where('NIP','=',$nip)->get();

            // return View::make('prodi.pesan', compact('data', 'namamhs', 'profile'));

        } else {
            return redirect('logout');
        }

    }

    public function upload($nim, $idfile)
    {
        
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');
        $idunit = Session::get('idunit');

        if (Session::has('access') && $idjabatan == "2") {

            $detail_file = TabelDetailFile::where('detail_file.NIM', '=', $nim)
                ->where('detail_file.ID_FILE', '=', $idfile)
                ->join('wisudawan','detail_file.NIM','=','wisudawan.NIM')->get();
            
            $profile = TabelPegawai::where('NIP','=',$nip)->get();

            return View::make('prodi.upload', compact('detail_file', 'profile'));

        } else {
            return redirect('logout');
        }

    }

    public function uploadPost($nim, $idfile, DropboxStorageRepository $connection, Googl $googl, Request $request)
    {
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');
        $idunit = Session::get('idunit');

        $nim    = $nim;
        $fy     = $idfile;
        $fileyudisium     = Input::get('fileyudisium');

        if (Session::has('access') && $idjabatan == "2") {

            $cloud = TabelCloudStorage::where('STATUS_CLOUD', '=', '1')->orderBy('ID_CLOUD', 'desc')->skip(0)->take(1)->get(['ID_CLOUD']);

            foreach ($cloud as $idcloud) {
                $idstorage = $idcloud->ID_CLOUD;
            }

            $NAMA_FILE  = TabelFileYudisium::where('file_yudisium.ID_FILE','=',$fy)->pluck('NAMA_FILE');
            $INISIAL  = TabelFileYudisium::where('file_yudisium.ID_FILE','=',$fy)->pluck('INISIAL');

            if ($idstorage == '1') {
                // return 'dropbox';
                if (Input::hasFile('fileyudisium')) {
                    
                    $fileyudisium     = Input::file('fileyudisium');
                    try {
                        //upload file to dropbox
                        $filesystem = $connection->getConnection();
                        $filesystem->put($INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension(), File::get($fileyudisium));
                        //upload file to server
                        $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                        Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                        DB::table('detail_file')
                            ->where('NIM', $nim)
                            ->where('ID_FILE', $fy)
                            ->update(array(
                                'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                'KETERANGAN'    => $NAMA_FILE,));

                        return Redirect::to("detail_mhs/".$nim."")->with('register_success', ' <b>File berhasil diupload! </b>');

                    } catch (\Exception $e) {

                        //upload file to server
                        $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                        Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                        DB::table('detail_file')
                            ->where('NIM', $nim)
                            ->where('ID_FILE', $fy)
                            ->update(array(
                                'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                'KETERANGAN'    => $NAMA_FILE,));

                        return Redirect::to("detail_mhs/".$nim."")->with('register_success', ' <b>File berhasil diupload! </b>');
                    }

                } 
                
                else {
                    return Redirect::to("detail_mhs/".$nim."")->with('register_success', ' <b>File not present! </b>');
                }


            } else {
                // return 'Google Drive';

                if (Input::hasFile('fileyudisium')) {
                    
                    $fileyudisium     = Input::file('fileyudisium');
                    
                    $mime_type = $fileyudisium->getMimeType();
                    $title = $fileyudisium->getClientOriginalName();

                    $folderId = '0B8GZ2Dto7D6LMUVkWXJWQ1Bjczg';

                    $drive_file = new \Google_Service_Drive_DriveFile();
                    $drive_file->setName($INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension());     //buat rename file
                    $drive_file->setMimeType($mime_type);
                    $drive_file->setParents(array($folderId));

                    try {
                        
                        //upload file to Google Drive
                        $createdFile = $this->drive->files->create($drive_file, [
                            'data' => File::get($fileyudisium),
                            'mimeType' => $mime_type,
                            'uploadType' => 'multipart',
                        ]);
                        $file_id = $createdFile->getId();

                        //upload file to server
                        $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                        Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                        DB::table('detail_file')
                            ->where('NIM', $nim)
                            ->where('ID_FILE', $fy)
                            ->update(array(
                                'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                'KETERANGAN'    => $NAMA_FILE,));

                        return Redirect::to("detail_mhs/".$nim."")->with('register_success', ' <b>File berhasil diupload! </b>');

                    } catch (\Exception $e) {

                        //upload file to server
                        $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                        Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                        DB::table('detail_file')
                            ->where('NIM', $nim)
                            ->where('ID_FILE', $fy)
                            ->update(array(
                                'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                'KETERANGAN'    => $NAMA_FILE,));

                        return Redirect::to("detail_mhs/".$nim."")->with('register_success', ' <b>File berhasil diupload! </b>');
                    }

                } 
                
                else {
                    return Redirect::to("detail_mhs/".$nim."")->with('register_success', ' <b>File not present! </b>');
                }

            }
            


            
              
            

        } else {
            return redirect('logout');
        }

    }

}
