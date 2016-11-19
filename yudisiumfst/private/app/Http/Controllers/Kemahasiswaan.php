<?php
namespace App\Http\Controllers;
use Input, Validator, Response, Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\TabelWisudawan;
use App\TabelUnit;
use App\TabelJenis;
use App\TabelAgama;
use App\TabelPegawai;
use App\TabelDetailVerifikasi;
use App\TabelUserAccount;
use App\TabelPeriodeWisuda;
use App\TabelJadwalYudisium;
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

class Kemahasiswaan extends Controller {

    // public function inputSkpLama()
    // {
    //     $nip =Session::get('nip');
    //     $idjabatan = Session::get('jabatan');

    //     if (Session::has('access') && $idjabatan == "3") {

    //     $prodi = TabelUnit::where('KETERANGAN_UNIT', '=', 'Prodi')->get();

    //     $profile = TabelPegawai::where('NIP','=',$nip)
    //         ->get();
    //     return View::make('kemahasiswaan.inputskp', compact('profile','prodi'));
    //     } else {
    //         return redirect('logout');
    //     }
    // }

    public function inputSkp() {

        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "3") {
        
            $person = TabelWisudawan::where('wisudawan.VERIFIKASI_AK','=','0')
                ->whereNull('SKP')
                ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->get();
        
            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
        
            return View::make('kemahasiswaan.inputskpbaru', compact('person', 'profile'));
        } else {
            return redirect('logout');
        }

    }

    public function inputSkpSave()
    {
        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "3") {

            $nim              = Input::get('nim');
            $skp             = Input::get('skp');

            // $rules = array(
            //                // 'nim'        => 'required',
            //                'skp'   => 'required|numeric',
            //               );
            // $custom = array(
            //                // 'nim.required' => 'nim is required.',
            //                // 'skp.required' => 'skp is required.',
            //                'skp.numeric' => 'skp is numeric.',
            //               );

            // $validator = Validator::make(Input::all(), $rules, $custom);
                
            // if($validator->fails())
            // {
            //     // return 'error';
            //     return Redirect::to("inputskp");
            // }

            if ($nim == null) {
                return Redirect::to("inputskp");
            } else {
            
                foreach ($nim as $nimm) {

                    if ($skp[$nimm] == null) {
                        // return $nim[$nimm];
                        DB::table('wisudawan')->where('NIM', $nim[$nimm])
                        ->update([
                        'SKP'   => null,         
                        ]);

                    } else {

                        DB::table('wisudawan')->where('NIM', $nim[$nimm])
                        ->update([
                        'SKP'               => $skp[$nimm],         
                        ]);
                      
                        $username   = TabelUserAccount::where('NIP','=',$nip)->pluck('USERNAME');
                        $cekverifikasi = TabelDetailVerifikasi::where('NIM', '=', $nim[$nimm])->where('USERNAME', '=', $username)->get();

                        if ($cekverifikasi->count() > 0) {
                            DB::table('detail_verifikasi')->where('NIM', $nim[$nimm])->where('USERNAME', $username)
                                ->update([
                                'TGL_DETAIL_VERIFIKASI' => $this->datetime(),
                            ]);
                        } else {
                            DB::table('detail_verifikasi')->insert([
                                'NIM'                   => $nim[$nimm],
                                'USERNAME'              => $username,
                                'TGL_DETAIL_VERIFIKASI' => $this->datetime(),           
                            ]);
                        }

                    }
                }

                return Redirect::to("inputskp")->with('register_success', ' <b>Sukses! </b> Data berhasil disimpan.');
            }

        } else {
          return redirect('logout');
        }
    }

    // public function getJadwalyudisium() {

    //     $jadwalyudisium = TabelJadwalYudisium::where('STATUS_JADWAL_YUDISIUM', '=', '1')->orderBy('ID_JADWAL_YUDISIUM', 'desc')->skip(0)->take(1)->get(['ID_JADWAL_YUDISIUM']);

    //     foreach ($jadwalyudisium as $jadwalyudisium1) {
    //       return $jadwalyudisium1->ID_JADWAL_YUDISIUM;
    //     }
    // }

    // public function inputSkpSave()
    // {
    //     $nip =Session::get('nip');
    //     $idjabatan = Session::get('jabatan');

    //     if (Session::has('access') && $idjabatan == "3") {

    //         $nim              = Input::get('NIM');
    //         $nama             = Input::get('NAMA');
    //         $prodi            = Input::get('ID_PRODI');
    //         $skp              = Input::get('SKP');
    //         $input = Input::all();

    //         $nimnull = TabelWisudawan::all()->where('NIM', ($nim));
    //         $skpnull = DB::table('wisudawan')
    //                     ->where('NIM', ($nim))
    //                     ->whereNull('SKP')
    //                     ->where('VERIFIKASI_AK', '=', '0')
    //                     ->get(['NIM', 'SKP', 'VERIFIKASI_AK']);
    //         $skpnotnull = DB::table('wisudawan')
    //                     ->where('NIM', ($nim))
    //                     ->whereNotNull('SKP')
    //                     ->where('VERIFIKASI_AK', '=', '0')
    //                     ->get(['NIM', 'SKP', 'VERIFIKASI_AK']);

    //         $nimverifikasi = DB::table('wisudawan')
    //                     ->where('NIM', ($nim))
    //                     ->where('VERIFIKASI_AK', '=', '1')
    //                     ->get(['NIM', 'VERIFIKASI_AK']);
    //         $idjadwalyudisium = $this->getJadwalyudisium();

    //         if ($nimnull->count() < 1) {
    //             // return 'insert';
    //             DB::table('wisudawan')->insert([
    //             'NIM'                => $nim,
    //             'NAMA'               => $nama,
    //             'ID_UNIT'            => $prodi,
    //             'ID_JADWAL_YUDISIUM' => $idjadwalyudisium, 
    //             'ID_AGAMA'           => 'IS',
    //             'PASSWORD_TEMP'      => null,
    //             'JENIS_KELAMIN'      => null,
    //             'TGL_TERDAFTAR'      => 0000-00-00,
    //             'TGL_LULUS'          => 0000-00-00,
    //             'IPK'                => null,
    //             'ELPT'               => null,
    //             'SKP'                => $skp,
    //             'BIDANG_ILMU'        => null,
    //             'JUDUL_SKRIPSI'      => null,
    //             'DOSEN_PEMBIMBING_1' => null,
    //             'DOSEN_PEMBIMBING_2' => null,
    //             'TEMPAT_LAHIR'       => null,
    //             'TANGGAL_LAHIR'      => 0000-00-00,
    //             'ALAMAT'             => null,
    //             'TELPON'             => null,
    //             'NAMA_ORTU'          => null,
    //             'ALAMAT_ORTU'        => null,
    //             'TELPON_ORTU'        => null,
    //             'VERIFIKASI'         => "0",
    //             // 'VERIFIKASI_KM'      => "1",
    //             'VERIFIKASI_AK'      => "0",
    //             'TGL_DAFTAR_YUDISIUM'=> "0000-00-00 00:00:00",           
    //             ]);

    //             $username   = TabelUserAccount::where('NIP','=',$nip)->pluck('USERNAME');

    //             $cekverifikasi = TabelDetailVerifikasi::where('NIM', '=', $nim)->where('USERNAME', '=', $username)->get();

    //             if ($cekverifikasi->count() > 0) {
    //               DB::table('detail_verifikasi')->where('NIM', $nim)->where('USERNAME', $username)
    //                   ->update([
    //                   'TGL_DETAIL_VERIFIKASI' => $this->datetime(),
    //                   ]);
    //             } else {
    //               DB::table('detail_verifikasi')->insert([
    //                   'NIM'                   => $nim,
    //                   'USERNAME'              => $username,
    //                   'TGL_DETAIL_VERIFIKASI' => $this->datetime(),           
    //                   ]);
    //             }

    //             return Redirect::to("inputskp")->with('register_success', ' <b>Sukses! </b> Data berhasil disimpan.');
    //         } else if ($skpnull == true) {

    //             DB::table('wisudawan')->where('NIM', $nim)
    //               ->update([
    //                     'SKP'                => $skp,
    //                     // 'VERIFIKASI_KM'      => "1",           
    //                     ]);

    //             $username   = TabelUserAccount::where('NIP','=',$nip)->pluck('USERNAME');

    //             $cekverifikasi = TabelDetailVerifikasi::where('NIM', '=', $nim)->where('USERNAME', '=', $username)->get();

    //             if ($cekverifikasi->count() > 0) {
    //               DB::table('detail_verifikasi')->where('NIM', $nim)->where('USERNAME', $username)
    //                   ->update([
    //                   'TGL_DETAIL_VERIFIKASI' => $this->datetime(),
    //                   ]);
    //             } else {
    //               DB::table('detail_verifikasi')->insert([
    //                   'NIM'                   => $nim,
    //                   'USERNAME'              => $username,
    //                   'TGL_DETAIL_VERIFIKASI' => $this->datetime(),           
    //                   ]);
    //             }

    //             return Redirect::to("inputskp")->with('register_success', ' <b>Sukses! </b> Data berhasil disimpan.');
    //         } else if ($skpnotnull == true) {

    //             DB::table('wisudawan')->where('NIM', $nim)
    //               ->update([
    //                     'SKP'                => $skp,
    //                     // 'VERIFIKASI_KM'      => "1",           
    //                     ]);

    //             $username   = TabelUserAccount::where('NIP','=',$nip)->pluck('USERNAME');

    //             $cekverifikasi = TabelDetailVerifikasi::where('NIM', '=', $nim)->where('USERNAME', '=', $username)->get();

    //             if ($cekverifikasi->count() > 0) {
    //               DB::table('detail_verifikasi')->where('NIM', $nim)->where('USERNAME', $username)
    //                   ->update([
    //                   'TGL_DETAIL_VERIFIKASI' => $this->datetime(),
    //                   ]);
    //             } else {
    //               DB::table('detail_verifikasi')->insert([
    //                   'NIM'                   => $nim,
    //                   'USERNAME'              => $username,
    //                   'TGL_DETAIL_VERIFIKASI' => $this->datetime(),           
    //                   ]);
    //             }

    //             return Redirect::to("inputskp")->with('register_success', ' <b>Sukses! </b> Data berhasil disimpan.');
    //         } else if ($nimverifikasi == true) {
    //             return Redirect::to("inputskp")->withInput()->with('register_danger', ' <b>Oops...! </b> Mahasiswa sudah menjadi wisudawan.');
    //         }
            

    //     $prodi = TabelUnit::where('KETERANGAN_UNIT', '=', 'Prodi')->get();

    //     $profile = TabelPegawai::where('NIP','=',$nip)
    //         ->get();
    //     return View::make('kemahasiswaan.inputskp', compact('profile','prodi'));
    //     } else {
    //         return redirect('logout');
    //     }
    // }
    
    public function listYudisium() {

        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "3") {
        
            $person = TabelWisudawan::where('wisudawan.VERIFIKASI_AK','=','0')
                // ->where('VERIFIKASI_AK','=','0')
                ->whereNotNull('SKP')
                ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->join('detail_verifikasi','wisudawan.NIM','=','detail_verifikasi.NIM')
                ->orderBy('TGL_DETAIL_VERIFIKASI', 'DESC')
                ->groupBy('wisudawan.NIM')
                ->get();
        
            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
        
            return View::make('kemahasiswaan.list_yudisium', compact('person', 'profile'));
        } else {
            return redirect('logout');
        }

    }

    public function edit($id) {

        $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->find($id);
    
        return Response::json($person);
    
    }

    public function datetime(){
        date_default_timezone_set('asia/jakarta');
        $datetime = date('Y-m-d h:i:sa');
        return $datetime;
    }

    public function editSkp(Request $request, $id) {

        $NIM     = Input::get('NIM');
        $NAMA    = Input::get('NAMA');
        $UNIT     = Input::get('UNIT');
        $SKP     = Input::get('SKP');

        $rules = array(  
                       'SKP'    => 'required|numeric|min:0',
                       // 'SKP'    => 'required|numeric|min:100',
                      );
        $custom = array(
                       'SKP.required'   => 'SKP is required.',
                       'SKP.numeric'    => 'SKP must be a number.',
                       'SKP.min'        => 'SKP min 0.',
                      );

        $validator = Validator::make(Input::all(), $rules, $custom);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'errors'   =>$validator->errors(),
                ]);
        }

        $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                ->findOrFail($id);

        // $person->update($request->all());
        $person = DB::table('wisudawan')->where('NIM', $id)
                  ->update([
                  'SKP' => $SKP,
                  // 'VERIFIKASI_KM' => 1,
                  ]);
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

        $person = array(
            'NIM'      => $NIM,
            'NAMA'     => $NAMA,
            'UNIT'     => $UNIT,
            'SKP'      => $SKP,

        );

        return response()->json([
               'success'  => true,
               'data' => $person
               ]);
        
    }

    public function deleteSkp(Request $request, $id) {

        $ceknim = DB::table('wisudawan')->where('NIM', ($id))->whereNotNull('NAMA_ORTU')->get(['NIM', 'NAMA_ORTU']);

        if ($ceknim == true) {
            return response()->json([
                   'success'  => false,
                   ]);
        } else if ($ceknim == false) {
            $person = TabelWisudawan::join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                    ->findOrFail($id);
            
            $person->update(['SKP' => null, ]);

            return response()->json([
                   'success'  => true,
                   'data' => $person
                   ]);
        }
        
    }

    public function dataWisudawan() {

        $nip =Session::get('nip');
        $idjabatan = Session::get('jabatan');

        if (Session::has('access') && $idjabatan == "3") {
            
            $person = TabelWisudawan::where('wisudawan.VERIFIKASI','=','1')
            ->where('wisudawan.VERIFIKASI_AK','=','1')
            ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
            ->join('jadwal_yudisium','wisudawan.ID_JADWAL_YUDISIUM','=','jadwal_yudisium.ID_JADWAL_YUDISIUM')
            ->join('periode_wisuda','jadwal_yudisium.ID_PERIODE_WISUDA','=','periode_wisuda.ID_PERIODE_WISUDA')
            ->get();

            $profile = TabelPegawai::where('NIP','=',$nip)
            ->get();
            
            return View::make('kemahasiswaan.data_wisudawan', compact('person', 'profile'));
        } else {
            return redirect('logout');
        }
    }

}
