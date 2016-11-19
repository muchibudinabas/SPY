<?php
namespace App\Http\Controllers;
use Input, Validator, Response, Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\TabelAlumni;
use App\TabelAnggotaRuangbaca;
use App\TabelPinjamBuku;
use App\TabelKoleksi;
use App\TabelJenisPinjam;
use App\TabelJenisKoleksi;

use App\TabelUserAccount;
use App\TabelUnit;
use App\TabelPegawai;
use App\TabelDepartemen;
use App\TabelJenis;
use App\TabelAgama;
use App\TabelDetailPinjamBuku;
use App\TabelPinjam;
use App\TabelOrtuAlumni;
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
use PDF;
use Excel;

class RuangBaca extends Controller {

    public function daftarAnggota() {
        
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "1") {
            
            $person = TabelAnggotaRuangbaca::join('unit','anggota_ruangbaca.ID_UNIT','=','unit.ID_UNIT')
                ->get();

            $nip = Session::get('nip');
            $profile = TabelPegawai::where('NIP','=',$nip)->get();

            $prodi = TabelUnit::where('KETERANGAN_UNIT', '=', 'Prodi')->get(); 

            return View::make('ruangbaca.daftar_anggota', compact('person', 'profile', 'prodi'));
        } else {
            return redirect('logout');
        }
    }

    public function storeDaftarAnggota(Request $request) {

        $NIM_ANGGOTA        = Input::get('NIM_ANGGOTA');
        $NAMA_ANGGOTA       = Input::get('NAMA_ANGGOTA');
        $ID_UNIT           = Input::get('ID_UNIT');
        $UNIT              = Input::get('UNIT');
        $ALAMAT_ANGGOTA     = Input::get('ALAMAT_ANGGOTA');
        $TELPON_ANGGOTA     = Input::get('TELPON_ANGGOTA');

        $rules  = array(
            'NIM_ANGGOTA'       => array('required','min:11','max:12','unique:anggota_ruangbaca,NIM_ANGGOTA','regex:/^[0-9]+$/i'),
            'NAMA_ANGGOTA'      => 'required|min:3',
            'ALAMAT_ANGGOTA'    => 'required|min:10',
            'ID_UNIT'          => 'required',
            'TELPON_ANGGOTA'    => 'required',
          );
        
        $custom = array(
           'NIM_ANGGOTA.required'       => 'NIM is required.',
           'NIM_ANGGOTA.regex'          => ' NIM must be a number.',
           'NIM_ANGGOTA.min'            => ' NIM must be at least 11 characters.',
           'NIM_ANGGOTA.max'            => ' NIM may not be greater than 12 characters.',
           'NIM_ANGGOTA.unique'         => ' NIM has already been taken.',
           'NAMA_ANGGOTA.required'      => ' NAMA is required.',
           'NAMA_ANGGOTA.min'           => ' NAMA may not be greater than 3 characters.',
           'ALAMAT_ANGGOTA.required'    => ' ALAMAT is required.',
           'ALAMAT_ANGGOTA.min'         => ' ALAMAT may not be greater than 10 characters.',
           'ID_UNIT.required'          => ' PRODI is required.',
           'TELPON_ANGGOTA.required'    => ' TELPON is required.',

          );

        $validator = Validator::make(Input::all(), $rules, $custom);
            
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'errors'   => $validator->errors()->toArray()
                ]);
        }

        $person = DB::table('anggota_ruangbaca')->insert([

            'NIM_ANGGOTA'      => $NIM_ANGGOTA,
            'NAMA_ANGGOTA'     => $NAMA_ANGGOTA,
            'ALAMAT_ANGGOTA'   => $ALAMAT_ANGGOTA,
            'TELPON_ANGGOTA'   => $TELPON_ANGGOTA,
            'ID_UNIT'         => $ID_UNIT,
            ]);

        $person = array(
            'NIM_ANGGOTA'       => $NIM_ANGGOTA, 
            'NAMA_ANGGOTA'      => $NAMA_ANGGOTA,
            'ID_UNIT'          => $ID_UNIT,
            'UNIT'             => $UNIT,
            'ALAMAT_ANGGOTA'    => $ALAMAT_ANGGOTA,
            'TELPON_ANGGOTA'    => $TELPON_ANGGOTA,
             );

        return response()->json([
               'success'  => true,
               'data' => $person
               ]);
    }

    public function editDaftarAnggota($id)
    {
        $person = TabelAnggotaRuangbaca::join('unit','anggota_ruangbaca.ID_UNIT','=','unit.ID_UNIT')
                ->find($id);
        return Response::json($person);
    }

    public function updateDaftarAnggota($id)
    {
        $NIM_ANGGOTA     = Input::get('NIM_ANGGOTA');
        $NAMA_ANGGOTA    = Input::get('NAMA_ANGGOTA');
        $ID_UNIT    = Input::get('ID_UNIT');
        $UNIT    = Input::get('UNIT');

        $ALAMAT_ANGGOTA    = Input::get('ALAMAT_ANGGOTA');
        $TELPON_ANGGOTA    = Input::get('TELPON_ANGGOTA');

        $rules  = array(
            'NIM_ANGGOTA'   => array('required','min:11','max:12','regex:/^[0-9]+$/i'),
            'NAMA_ANGGOTA'    => 'required|min:3',
            'ALAMAT_ANGGOTA'      => 'required|min:10',
            'ID_UNIT'        => 'required',
            'TELPON_ANGGOTA'        => 'required',
          );

        $custom = array(
           'NIM_ANGGOTA.required' => 'NIM is required.',
           'NIM_ANGGOTA.regex' => ' NIM must be a number.',
           'NIM_ANGGOTA.min' => ' NIM must be at least 11 characters.',
           'NIM_ANGGOTA.max' => ' NIM may not be greater than 12 characters.',
           'NAMA_ANGGOTA.required' => ' NAMA is required.',
           'NAMA_ANGGOTA.min' => ' NAMA may not be greater than 3 characters.',
           'ALAMAT_ANGGOTA.required' => ' ALAMAT is required.',
           'ALAMAT_ANGGOTA.min' => ' ALAMAT may not be greater than 10 characters.',
           'ID_UNIT.required' => ' PRODI is required.',
           'TELPON_ANGGOTA.required' => ' TELPON is required.',
          );


        $validator = Validator::make(Input::all(), $rules, $custom);
            
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'errors'   => $validator->errors()->toArray()
                ]);
        }

        $person = TabelAnggotaRuangbaca::where('NIM_ANGGOTA', $NIM_ANGGOTA)
            ->update(['NAMA_ANGGOTA' => $NAMA_ANGGOTA,
                    'ALAMAT_ANGGOTA' => $ALAMAT_ANGGOTA,
                    'TELPON_ANGGOTA' => $TELPON_ANGGOTA,
                          'ID_UNIT' => $ID_UNIT,]);

        $person = array(
            'NIM_ANGGOTA'       => $NIM_ANGGOTA, 
            'NAMA_ANGGOTA'      => $NAMA_ANGGOTA,
            'ID_UNIT'          => $ID_UNIT,
            'UNIT'             => $UNIT,
            'ALAMAT_ANGGOTA'    => $ALAMAT_ANGGOTA,
            'TELPON_ANGGOTA'    => $TELPON_ANGGOTA,
             );

        return response()->json([
               'success'  => true,
               'data' => $person
               ]);
    }

    public function destroyDaftarAnggota($id) {
        TabelAnggotaRuangbaca::destroy($id);
        return response()->json([
               'success' => true,
               ]);
    }

    public function pinjamBuku() {

        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "1") {
            $person = TabelDetailPinjamBuku::where('detail_pinjam_buku.STATUS_PINJAM','=', '0')
                ->join('koleksi','detail_pinjam_buku.ID_KOLEKSI','=','koleksi.ID_KOLEKSI')
                ->join('jenis_koleksi','koleksi.ID_JENIS_KOLEKSI','=','jenis_koleksi.ID_JENIS_KOLEKSI')
                ->join('jenis_pinjam','detail_pinjam_buku.ID_JENIS_PINJAM','=','jenis_pinjam.ID_JENIS_PINJAM')  
                ->join('pinjam','detail_pinjam_buku.ID_PINJAM_BUKU','=','pinjam.ID_PINJAM_BUKU')  
                ->join('anggota_ruangbaca','pinjam.NIM_ANGGOTA','=','anggota_ruangbaca.NIM_ANGGOTA')  
                ->join('unit','anggota_ruangbaca.ID_UNIT','=','unit.ID_UNIT')  
                ->get();
                // return $person;

            $nip = Session::get('nip');
            $profile = TabelPegawai::where('NIP','=',$nip)->get();

            // $prodi = TabelUnit::where('KETERANGAN_UNIT', '=', 'Prodi')->get(); 
            $koleksi = TabelJenisKoleksi::all(); 
            $jenispinjam = TabelJenisPinjam::all(); 

            return View::make('ruangbaca.pinjam_buku', compact('person','profile', 'koleksi', 'jenispinjam'));
        } else {
            return redirect('logout');
        }

    }

    public function getDateNow()
    {
        $dt = Carbon::now('Asia/Jakarta');
        return $dt->toDateString();
    }

    public function getDateOneWeek()
    {
        date_default_timezone_set('asia/jakarta');
        $start_date = date('Y-m-d');  
        $date = strtotime($start_date);
        $date = strtotime("+7 day", $date);
        return date('Y-m-d', $date);
    }

    public function dateDMY() {

        date_default_timezone_set('asia/jakarta');
        return $date = date('d-m-Y');  
    }

    public function dateDMYoneWeek() {

        date_default_timezone_set('asia/jakarta');
        $start_date = date('Y-m-d');  
        $date = strtotime($start_date);
        $date = strtotime("+7 day", $date);
        return date('d-m-Y', $date); 
    
    }

    public function getlastidpinjambuku()
    {
        $data = DB::table('pinjam')->orderBy('ID_PINJAM_BUKU', 'desc')->skip(0)->take(1)->get();

        // $data = DB::select("SELECT (ID_PINJAM_BUKU) FROM pinjam WHERE LENGTH(ID_PINJAM_BUKU) = (SELECT MAX(LENGTH(ID_PINJAM_BUKU)) FROM pinjam) ORDER BY ID_PINJAM_BUKU  DESC LIMIT 1");

        // $data =TabelPinjam::orderBy('ID_PINJAM_BUKU', 'DESC')->whereRaw('LENGTH(ID_PINJAM_BUKU) >1')->get();

        // $data =DB::table('pinjam')
        // ->select('ID_PINJAM_BUKU')
        // ->orderByRaw('LENGTH(ID_PINJAM_BUKU) DESC')->get();

        foreach ($data as $data1) {
            return $data1->ID_PINJAM_BUKU;
        }
    }

    public function getlastidkoleksi()
    {
        // $data = DB::table('koleksi')->where('ID_KOLEKSI', DB::raw("(select max('ID_KOLEKSI') from koleksi)"))->get();
        // $data = DB::table('koleksi')->lenght('ID_KOLEKSI')->get();

        $data = DB::table('koleksi')->orderBy('ID_KOLEKSI', 'desc')->skip(0)->take(1)->get();


        foreach ($data as $data1) {
            return $data1->ID_KOLEKSI;
        }
    }

    public function storePinjamBuku(Request $request)
    {
        $ID_PINJAM_BUKU    = $this->getlastidpinjambuku();
        $ID_KOLEKSI        = $this->getlastidkoleksi();
        $value  = 1;
        $NIP = Session::get('nip');
        $NIM_PEMINJAM     = Input::get('NIM_PEMINJAM');
        // $NAMA_PEMINJAM    = Input::get('NAMA_PEMINJAM');
        // $ID_UNIT         = Input::get('ID_UNIT');
        // $UNIT            = Input::get('UNIT');
        $NO_KLAS          = Input::get('NO_KLAS');
        $PENGARANG        = Input::get('PENGARANG');
        $JUDUL            = Input::get('JUDUL');
        $ID_JENIS_KOLEKSI       = Input::get('ID_JENIS_KOLEKSI');
        $JENIS_KOLEKSI          = Input::get('JENIS_KOLEKSI');
        $ID_JENIS_PINJAM  = Input::get('ID_JENIS_PINJAM');
        $JENIS_PINJAM     = Input::get('JENIS_PINJAM');
        // $TGL_PINJAM  = $this->getDateNow();
        // $TGL_KEMBALI = $this->getDateOneWeek(); 

        $rules  = array(
            'NIM_PEMINJAM'      => array('required','min:11','max:12','regex:/^[0-9]+$/i'),
            // 'NAMA_PEMINJAM'     => 'required|min:3',
            // 'ID_UNIT'          => 'required',
            'ID_JENIS_PINJAM'   => 'required',
            'NO_KLAS'           => 'required',
            'PENGARANG'         => 'required',
            'JUDUL'             => 'required',
            'ID_JENIS_KOLEKSI'        => 'required',
          );

        $custom = array(
           'NIM_PEMINJAM.required'      => 'NIM is required.',
           'NIM_PEMINJAM.regex'         => ' NIM must be a number.',
           'NIM_PEMINJAM.min'           => ' NIM must be at least 11 characters.',
           'NIM_PEMINJAM.max'           => ' NIM may not be greater than 12 characters.',
           // 'NAMA_PEMINJAM.required'     => ' Nama is required.',
           // 'NAMA_PEMINJAM.min'          => ' Nama may not be greater than 3 characters.',
           // 'ID_UNIT.required'          => ' Prodi is required.',
           'ID_JENIS_PINJAM.required'   => ' Jenis Pinjam is required.',
           'NO_KLAS.required'           => ' No Klas is required.',
           'PENGARANG.required'         => ' Pengarang is required.',
           'JUDUL.required'             => ' Judul is required.',
           'ID_JENIS_KOLEKSI.required'        => ' Koleksi is required.',
          );

        $validator = Validator::make(Input::all(), $rules, $custom);
            
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'errors'   => $validator->errors()->toArray()
                ]);
        }

            $datanim = DB::select("SELECT NIM_ANGGOTA FROM `anggota_ruangbaca` WHERE `NIM_ANGGOTA` = '" . $NIM_PEMINJAM . "' ");

            $data = TabelAnggotaRuangbaca::where('NIM_ANGGOTA', '=', $NIM_PEMINJAM)
                    ->join('unit', 'anggota_ruangbaca.ID_UNIT', '=', "unit.ID_UNIT")->get();

            foreach ($data as $persons) {
                $NAMA_PEMINJAM = $persons->NAMA_ANGGOTA;
                $ID_UNIT = $persons->ID_UNIT;
                $UNIT = $persons->UNIT;
            }

            if ($datanim == true) {

                DB::table('pinjam')->insert([
                        'ID_PINJAM_BUKU'    => ((int)$ID_PINJAM_BUKU + $value),
                        'NIP'               => $NIP,
                        'NIM_ANGGOTA'       => $NIM_PEMINJAM,
                        'TGL_PINJAM'        => $this->datetime(),
                        ]);

                DB::table('koleksi')->insert([
                        'ID_KOLEKSI'        => ((int)$ID_KOLEKSI + $value),
                        'ID_JENIS_KOLEKSI'  => $ID_JENIS_KOLEKSI,
                        'JUDUL'             => $JUDUL,
                        'PENGARANG'         => $PENGARANG,
                        'NO_KLAS'           => $NO_KLAS,
                        ]);

                DB::table('detail_pinjam_buku')->insert([
                        'ID_PINJAM_BUKU'    => ((int)$ID_PINJAM_BUKU + $value),
                        'ID_JENIS_PINJAM'   => $ID_JENIS_PINJAM,
                        'NIP'               => null,
                        'ID_KOLEKSI'        => ($ID_KOLEKSI + $value),
                        'STATUS_PINJAM'     => "0",
                        ]);

                if ($ID_JENIS_PINJAM == "1" || $ID_JENIS_PINJAM == "2") {
                    $JATUH_TEMPO = ' ';
                } else if ($ID_JENIS_PINJAM == "3") {
                    $JATUH_TEMPO = $this->dateDMYoneWeek();
                }
                
                if ($ID_JENIS_PINJAM == "1") {
                    $Fotocopy = 'Fotocopy';
                    $Membaca = '';
                    $Pinjam = '';
                }
                if ($ID_JENIS_PINJAM == "2") {
                    $Fotocopy = '';
                    $Membaca = 'Membaca';
                    $Pinjam = '';
                }
                if ($ID_JENIS_PINJAM == "3") {
                    $Fotocopy = '';
                    $Membaca = '';
                    $Pinjam = 'Pinjam';
                }

                $person = array(
                    'ID_PINJAM_BUKU'    => ((int)$ID_PINJAM_BUKU + $value),
                    'NIM_PEMINJAM'      => $NIM_PEMINJAM, 
                    'NAMA_PEMINJAM'     => $NAMA_PEMINJAM,
                    'ID_UNIT'           => $ID_UNIT,
                    'UNIT'              => $UNIT,
                    'ID_JENIS_PINJAM'   => $ID_JENIS_PINJAM,
                    // 'JENIS_PINJAM'      => $JENIS_PINJAM,
                    'Fotocopy'          => $Fotocopy,
                    'Membaca'           => $Membaca,
                    'Pinjam'            => $Pinjam,
                    'NO_KLAS'           => $NO_KLAS,
                    'PENGARANG'         => $PENGARANG,
                    'JUDUL'             => $JUDUL,
                    'ID_JENIS_KOLEKSI'  => $ID_JENIS_KOLEKSI,
                    'JENIS_KOLEKSI'     => $JENIS_KOLEKSI,
                    'TGL_PINJAM'        => $this->dateDMY(),
                    // 'TGL_KEMBALI'       => $this->dateDMYoneWeek(),
                    'TGL_KEMBALI'       => $JATUH_TEMPO,
                     );

                return response()->json([
                       'success'  => true,
                       'data' => $person
                       ]);

            } else {

                return response()->json([
                'success' => false,
                'errors'   => ["Maaf NIM belum terdaftar sebagai Anggota Ruang Baca"]
                ]);
            }
        
    }

    public function editPinjamBuku($id) {
        $person = TabelPinjamBuku::join('jenis_pinjam','pinjam_buku.ID_JENIS_PINJAM','=','jenis_pinjam.ID_JENIS_PINJAM')
                ->join('koleksi','pinjam_buku.ID_KOLEKSI','=','koleksi.ID_KOLEKSI')
                ->join('prodi','pinjam_buku.ID_PRODI','=','prodi.ID_PRODI')
                ->find($id);
        return Response::json($person);
    }

    public function datetime(){
        date_default_timezone_set('asia/jakarta');
        $datetime = date('Y-m-d h:i:sa');
        return $datetime;
    }

    public function kembalikanBuku(Request $request, $id) {

        // $person = TabelDetailPinjamBuku::findOrFail($id);
        $NIP = Session::get('nip');
        // $TGL_KEMBALI = $this->getDateNow();
        $person = TabelDetailPinjamBuku::where('ID_PINJAM_BUKU', $id)
            ->update(['NIP' => $NIP,
                    'STATUS_PINJAM' => '1',
                    'TGL_KEMBALI' =>  $this->datetime(),]);

        // $person->update(['STATUS_PINJAM' => 1,'TGL_KEMBALI' => $TGL_KEMBALI]);
        return response()->json([
               'success'  => true,
               'data' => $person
               ]);
    }

    public function detailPinjam($nim, $id){

        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "1") {

            $data = TabelDetailPinjamBuku::join('jenis_pinjam','detail_pinjam_buku.ID_JENIS_PINJAM','=','jenis_pinjam.ID_JENIS_PINJAM')
                ->join('koleksi','detail_pinjam_buku.ID_KOLEKSI','=','koleksi.ID_KOLEKSI')
                ->join('jenis_koleksi','koleksi.ID_JENIS_KOLEKSI','=','jenis_koleksi.ID_JENIS_KOLEKSI')
                ->join('pinjam','detail_pinjam_buku.ID_PINJAM_BUKU','=','pinjam.ID_PINJAM_BUKU')
                ->join('pegawai','pinjam.NIP','=','pegawai.NIP')
                ->join('anggota_ruangbaca','pinjam.NIM_ANGGOTA','=','anggota_ruangbaca.NIM_ANGGOTA')
                ->join('jabatan','pegawai.ID_JABATAN','=','jabatan.ID_JABATAN')
                ->join('unit','anggota_ruangbaca.ID_UNIT','=','unit.ID_UNIT')
                ->where('detail_pinjam_buku.ID_PINJAM_BUKU','=', $id)  
                ->where('pinjam.NIM_ANGGOTA','=', $nim)  
                ->get();

            $data1 = TabelDetailPinjamBuku::join('pegawai','detail_pinjam_buku.NIP','=','pegawai.NIP')
                ->join('jabatan','pegawai.ID_JABATAN','=','jabatan.ID_JABATAN')
                ->where('detail_pinjam_buku.ID_PINJAM_BUKU','=', $id)  
                ->get();

            $nip = Session::get('nip');
            $profile = TabelPegawai::where('NIP','=',$nip)->get();

            return View::make('ruangbaca.detail_pinjam', compact('data', 'profile', 'data1'));
        } 
        else {
            return redirect('logout');
        }
    }

    public function historyPinjamBuku()
    {
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "1") {
            
            $person = TabelDetailPinjamBuku::where('detail_pinjam_buku.STATUS_PINJAM','=', '1')
                ->join('koleksi','detail_pinjam_buku.ID_KOLEKSI','=','koleksi.ID_KOLEKSI')
                ->join('jenis_koleksi','koleksi.ID_JENIS_KOLEKSI','=','jenis_koleksi.ID_JENIS_KOLEKSI')
                ->join('jenis_pinjam','detail_pinjam_buku.ID_JENIS_PINJAM','=','jenis_pinjam.ID_JENIS_PINJAM')  
                ->join('pinjam','detail_pinjam_buku.ID_PINJAM_BUKU','=','pinjam.ID_PINJAM_BUKU')  
                ->join('anggota_ruangbaca','pinjam.NIM_ANGGOTA','=','anggota_ruangbaca.NIM_ANGGOTA')  
                ->join('unit','anggota_ruangbaca.ID_UNIT','=','unit.ID_UNIT')
                ->orderBy('pinjam.TGL_PINJAM', 'DESC')  
                ->get();
            
            $nip = Session::get('nip');
            $profile = TabelPegawai::where('NIP','=',$nip)->get();


            return View::make('ruangbaca.history_pinjam_buku', compact('person','profile'));
        } else {
            return redirect('logout');
        }

    }

    public function exportExcel() {

         $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "1") {

            $data = TabelDetailPinjamBuku::where('detail_pinjam_buku.STATUS_PINJAM','=', '1')
                ->join('koleksi','detail_pinjam_buku.ID_KOLEKSI','=','koleksi.ID_KOLEKSI')
                ->join('jenis_koleksi','koleksi.ID_JENIS_KOLEKSI','=','jenis_koleksi.ID_JENIS_KOLEKSI')
                ->join('jenis_pinjam','detail_pinjam_buku.ID_JENIS_PINJAM','=','jenis_pinjam.ID_JENIS_PINJAM')  
                ->join('pinjam','detail_pinjam_buku.ID_PINJAM_BUKU','=','pinjam.ID_PINJAM_BUKU')  
                ->join('anggota_ruangbaca','pinjam.NIM_ANGGOTA','=','anggota_ruangbaca.NIM_ANGGOTA')  
                ->join('unit','anggota_ruangbaca.ID_UNIT','=','unit.ID_UNIT')  
                ->orderBy('pinjam.TGL_PINJAM', 'DESC')
                ->select(DB::raw("anggota_ruangbaca.NIM_ANGGOTA, anggota_ruangbaca.NAMA_ANGGOTA, UNIT as PRODI, anggota_ruangbaca.ALAMAT_ANGGOTA, anggota_ruangbaca.TELPON_ANGGOTA,
                    NO_KLAS, JUDUL, PENGARANG, NO_KLAS, JENIS_KOLEKSI, JENIS_PINJAM, DATE_FORMAT(TGL_PINJAM, '%d %M %Y') as TGL_PINJAM, DATE_FORMAT(TGL_KEMBALI, '%d %M %Y') as TGL_KEMBALI
                    "))
                ->get();

            $date = date('Y-m-d');

            Excel::create('Histori Pinjam Buku '.$date.'', function($excel) use($data) {

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
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "1") {

        $nip = Session::get('nip');
        $profile = TabelPegawai::where('NIP','=',$nip)->get();

        return View::make('ruangbaca.cetaksurat', compact('profile'));
        } else {
            return redirect('logout');
        }
    }

    public function postCetakSurat() {
        date_default_timezone_set('asia/jakarta');
        $date = date('Y-m-d');
        $BulanIndo = array("Januari", "Februari", "Maret",
                           "April", "Mei", "Juni",
                           "Juli", "Agustus", "September",
                           "Oktober", "November", "Desember");

        $tahun = substr($date, 0, 4); 
        $bulan = substr($date, 5, 2); 
        $tgl   = substr($date, 8, 2); 
        
        $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;

        $NIM = Input::get('NIM');

        $cekanggota = TabelAnggotaRuangbaca::where('NIM_ANGGOTA', '=', $NIM)
                ->join('unit', 'anggota_ruangbaca.ID_UNIT', '=', 'unit.ID_UNIT')->get();
        $cekpinjam = TabelPinjam::where('pinjam.NIM_ANGGOTA', '=', $NIM)
                ->where('detail_pinjam_buku.STATUS_PINJAM', '=', '0')
                ->join('detail_pinjam_buku','pinjam.ID_PINJAM_BUKU', '=','detail_pinjam_buku.ID_PINJAM_BUKU')
                ->get();

        if ($cekanggota->count() > 0) {
            if ($cekpinjam->count() > 0) {

                $nip = Session::get('nip');
                $profile = TabelPegawai::where('NIP','=',$nip)->get();

                $datapinjam = TabelPinjam::where('pinjam.NIM_ANGGOTA', '=', $NIM)
                            ->where('detail_pinjam_buku.STATUS_PINJAM', '=', '0')
                            ->join('anggota_ruangbaca', 'pinjam.NIM_ANGGOTA', '=', 'anggota_ruangbaca.NIM_ANGGOTA')
                            ->join('unit', 'anggota_ruangbaca.ID_UNIT', '=', 'unit.ID_UNIT')
                            ->join('detail_pinjam_buku', 'pinjam.ID_PINJAM_BUKU', '=', 'detail_pinjam_buku.ID_PINJAM_BUKU')
                            ->join('jenis_pinjam', 'detail_pinjam_buku.ID_JENIS_PINJAM', '=', 'jenis_pinjam.ID_JENIS_PINJAM') 
                            ->join('koleksi', 'detail_pinjam_buku.ID_KOLEKSI', '=', 'koleksi.ID_KOLEKSI')
                            ->join('jenis_koleksi', 'koleksi.ID_JENIS_KOLEKSI', '=', 'jenis_koleksi.ID_JENIS_KOLEKSI')
                            ->get();

                foreach ($datapinjam as $data) {
                    $nim = $data->NIM_ANGGOTA;
                    $nama =$data->NAMA_ANGGOTA;
                    $unit =$data->UNIT;
                }
                return View::make('ruangbaca.cetaksurat2', compact('profile','datapinjam', 'nim','nama', 'unit'));

                // return Redirect::to("cetaksuratbebaspinjam")->withInput()->with(compact('datapinjam'), 'register_warning', ' <b>Oops...! </b> Mahasiswa masih mempunyai tanggungan peminjaman buku.');
            } else {

                foreach ($cekanggota as $dataa) {
                    $NAMA_ANGGOTA = $dataa->NAMA_ANGGOTA;
                    $UNIT = $dataa->UNIT;
                }

                $JENJANG = explode(' ', $UNIT);
                if ($JENJANG[0] = 'S1') {
                    $JENJANG = 'Sarjana';
                } else if ($JENJANG[0] = 'S2') {
                    $JENJANG = 'Magister';
                } else if ($JENJANG[0] = 'S3') {
                    $JENJANG = 'Doktor';
                }

                $TANGGAL_UJIAN = Input::get('TANGGAL_UJIAN');
                $BulanIndo = array("Januari", "Februari", "Maret",
                                   "April", "Mei", "Juni",
                                   "Juli", "Agustus", "September",
                                   "Oktober", "November", "Desember");

                $tahun = substr($TANGGAL_UJIAN, 0, 4); 
                $bulan = substr($TANGGAL_UJIAN, 5, 2); 
                $tgl   = substr($TANGGAL_UJIAN, 8, 2); 

                $TANGGAL_UJIAN_BARU = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;

                $pdf = \App::make('dompdf.wrapper');

                // when on root use
                // $pdf = App::make('dompdf.wrapper');
                $html = '<html>
                <head>
                    <title></title>
                </head>
                <body>
                    <table width="100%">
                        <tr>
                            <td width="10" align="center"><img src="private/unair.gif" width="100" height="100"></td>
                            <td width="" align="center"><font size="3" ><b>DEPARTEMEN PENDIDIKAN NASIONAL<br></font>
                                <font size="3" ><b>UNIVERSITAS AIRLANGGA<br>
                                <b>FAKULTAS SAINS DAN TEKNOLOGI<br>
                                <font size="1" >Kampus C Jl. Mulyorejo Surabaya (60115) Telephone (031) 5936501, 5924614 Fax (031) 5936502<br>Website : http//www.fst.unair.ac.id – E-mail : fst@unair.ac.id</font>
                            </td>
                            <td width="8" align="center" ><img src="private/blank.png" width="100" height="100"></td>
                        </tr>
                    </table>
                    <img src="private/garis.png" align="center" width="704" height="">
                    <br style="line-height:1.5;">

                    <table width="100%">
                        <tr>
                            <!-- <td width="10" align="center"><img src="private/unair.jpg" width="100" height="100"></td> -->
                            <td width="" align="center"><font size="3" ><b>SURAT KETERANGAN <br>BEBAS PEMINJAMAN BUKU<br></font>

                            </td>
                            <!-- <td width="10" align="center" ><img src="private/unairblack.png" width="100" height="100"></td> -->
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
                                        <td align="left"><font size="3" ><b> '.$NAMA_ANGGOTA.'  </font></td>
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
                                        <td width="95" align="left" ><font size="3" ><b> '.$UNIT.' </font></td>
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
                                <font size="3" >Sudah tidak mempunyai tanggungan peminjaman/ penggantian buku/ jurnal/ majalah milik ruang baca Fakultas Sains Teknologi Universitas Airlangga. Surat keterangan ini untuk digunakan sebagai kelengkapan persyaratan lulus Program '.$JENJANG.' di Fakultas Sains Teknologi Universitas Airlangga.<br></font></p>
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
                            </td>
                            <td width="2" align="left">
                            </td>
                            <td width="48" align="left">
                                <p style="text-align: justify; line-height:100%;" >
                                <font size="3" >Petugas ruang baca<br>FSaintek Unair</font></p>
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
                            </td>
                            <td width="26" align="center">
                            </td>
                        </tr>
                    </table>
                </body>
                </html>';

                $pdf->loadHTML($html);
                return $pdf->stream('Surat Keterangan Bebas Pinjam Buku - '.$NIM.'.pdf');

            }
            
        } else {
            return Redirect::to("cetaksuratbebaspinjam")->withInput()->with('register_warning', ' <b>Oops...! </b> Mahasiswa belum mendaftar sebagai anggota ruang baca.');
        }
        

    }

}