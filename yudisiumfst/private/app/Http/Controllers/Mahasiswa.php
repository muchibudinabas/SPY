<?php
namespace App\Http\Controllers;
use App\Make;
use Redirect;
use App\Gettabeluser;
use App\TabelUserAccount;
use App\TabelAgama;
use App\TabelWisudawan;
use App\TabelJenisKelamin;
use App\TabelUnit;
use App\TabelJadwalYudisium;
use App\TabelDetailFile;
use App\TabelFileYudisium;
use App\TabelCloudStorage;

use App\Http\Controllers\belajarcontroler;
use App\User;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Auth\Guard;
use View;
use Input;
use Hash;
use DB;
use Session;
use Auth;
use Mail;
use Validator;
use Flash;
use App\Quotation;
use Carbon\Carbon;
use Response;
use File;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;

use Dropbox\Client;
use App\Repositories\DropboxStorageRepository;
use App\Repositories\Googl;

class Mahasiswa extends BaseController {

    private $client;
    private $drive;

    public function __construct(Googl $googl)
    {
        $this->client = $googl->client();
        $this->client->setAccessToken(session('user.token'));
        $this->drive = $googl->drive($this->client);

    }

  public function randompassword() {
    
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pool1 = '0123456789';
    $pool2 = 'abcdefghijklmnopqrstuvwxyz';
    $pool3 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, 5).substr(str_shuffle(str_repeat($pool1, 5)), 0, 1).substr(str_shuffle(str_repeat($pool2, 5)), 0, 1).substr(str_shuffle(str_repeat($pool3, 5)), 0, 1);
  }

  public function getJadwalyudisium() {

    $jadwalyudisium = TabelJadwalYudisium::where('STATUS_JADWAL_YUDISIUM', '=', '2')->orderBy('ID_JADWAL_YUDISIUM', 'desc')->skip(0)->take(1)->get(['ID_JADWAL_YUDISIUM']);

    foreach ($jadwalyudisium as $jadwalyudisium1) {
      return $jadwalyudisium1->ID_JADWAL_YUDISIUM;
    }
  }

  public function daftarYudisium(Request $request) {

        $ranpass = $this->randompassword();
        $idjadwalyudisium = $this->getJadwalyudisium();

        date_default_timezone_set('asia/jakarta');
        $date = date('Y-m-d');
        $datetime = date('Y-m-d h:i:sa');

        $nim              = Input::get('nim');
        $namamahasiswa    = Input::get('namamahasiswa');
        $prodi            = Input::get('prodi');
        $tglterdaftar     = Input::get('tglterdaftar');
        $ipk              = Input::get('ipk');
        $elpt             = Input::get('elpt');
        $bidangilmu       = Input::get('bidangilmu');
        $judulpenelitihan = Input::get('judulpenelitihan');
        $dosenpembimbing1 = Input::get('dosenpembimbing1');
        $dosenpembimbing2 = Input::get('dosenpembimbing2');
        $tempatlahir      = Input::get('tempatlahir');
        $tanggallahir     = Input::get('tanggallahir');
        $agama            = Input::get('agama');
        $jeniskelamin     = Input::get('jeniskelamin');
        $alamat           = Input::get('alamat');
        $telpon           = Input::get('telpon');

        $namaortu   = Input::get('namaortu');
        $alamatortu = Input::get('alamatortu');
        $telponortu = Input::get('telponortu');
        $input = Input::all();

        // foreach ($alamatortu as $alamatortuu) {
        //     DB::table('agama')->where('ID_AGAMA', $alamatortu[$alamatortuu])->update([
        //         'AGAMA'               => $namaortu[$alamatortuu],         
        //         ]);
        // }

        $nimnull = TabelWisudawan::all()->where('NIM', ($nim));
        $nimverifikasi = DB::table('wisudawan')
                        ->where('NIM', ($nim))
                        ->where('VERIFIKASI_AK', '=', '1')
                        ->get(['NIM', 'VERIFIKASI_AK']);
        $nimproses = DB::table('wisudawan')
                    ->where('NIM', ($nim))
                    ->whereNotNull('NAMA_ORTU')
                    ->where('VERIFIKASI_AK', '=', '0')
                    ->get(['NIM', 'NAMA_ORTU', 'VERIFIKASI_AK']);

        if ($idjadwalyudisium == null) {
            return Redirect::to("/#daftaryudisium")->withInput()->with('register_danger', ' <b>Oops...! </b> Jadwal yudisium belum dibuka.');
        } else if ($nimnull->count() < 1) {

          DB::table('wisudawan')->insert([
                'NIM'                => $nim,
                'NAMA'               => $namamahasiswa,
                'ID_UNIT'            => $prodi,
                'ID_JADWAL_YUDISIUM' => $idjadwalyudisium, 
                'ID_AGAMA'           => $agama,
                'PASSWORD_TEMP'      => $ranpass,
                'JENIS_KELAMIN'      => $jeniskelamin,
                'TGL_TERDAFTAR'      => $tglterdaftar,
                'TGL_LULUS'          => 0000-00-00,
                'IPK'                => $ipk,
                'ELPT'               => $elpt,
                'BIDANG_ILMU'        => $bidangilmu,
                'JUDUL_SKRIPSI'      => $judulpenelitihan,
                'DOSEN_PEMBIMBING_1' => $dosenpembimbing1,
                'DOSEN_PEMBIMBING_2' => $dosenpembimbing2,
                'TEMPAT_LAHIR'       => $tempatlahir,
                'TANGGAL_LAHIR'      => $tanggallahir,
                'ALAMAT'             => $alamat,
                'TELPON'             => $telpon,
                'NAMA_ORTU'          => $namaortu,
                'ALAMAT_ORTU'        => $alamatortu,
                'TELPON_ORTU'        => $telponortu,
                'VERIFIKASI'         => "0",
                'VERIFIKASI_AK'      => "0",
                // 'VERIFIKASI_KM'      => "0",
                'TGL_DAFTAR_YUDISIUM'=> $datetime,           
                ]);

              Session::put('nim', $nim);

            return Redirect::to("/dashboard")->with('register_success', ' <b>Pendaftaran Yudisium Berhasil! </b><br> Silahkan upload file yudisium untuk melengkapi proses pendaftaran yudisium, ');
        
        } else if ($nimverifikasi == true) {
            return Redirect::to("/#daftaryudisium")->withInput()->with('register_danger', ' <b>Oops...! </b> Anda sudah menjadi wisudawan, silahkan menemui petugas Akademik.');
        
        } else if ($nimproses == true) {
            return Redirect::to("/#daftaryudisium")->withInput()->with('register_danger', ' <b>Oops...! </b> Anda dalam proses pendaftaran yudisium, silahkan menemui TU Prodi untuk meminta verifikasi pendaftaran yudisium dengan membawa <em>(hardcopy)</em> persyaratan yudisium.');
        }

    }

    public function dashboard(Googl $googl){
    
      if (Session::get('nim')==true){
  
        $nim = Session::get('nim');
        $data = TabelWisudawan::where('NIM', '=', ($nim))
              ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
              ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')->get();

        $file_yudisium = TabelFileYudisium::where('STATUS', '=', '1')
            ->where('jadwal_yudisium.STATUS_JADWAL_YUDISIUM', '=', '2')
            // ->where('detail_file.NIM', '=', $nim)
            ->join('jadwal_yudisium', 'file_yudisium.ID_JADWAL_YUDISIUM', '=', 'jadwal_yudisium.ID_JADWAL_YUDISIUM')
            // ->join('detail_file', 'file_yudisium.ID_FILE', '=', 'detail_file.ID_FILE')
            ->get();

        $pesan = TabelDetailFile::where('NIM', '=', $nim)->get();
        
        return View::make('mahasiswa.dashboard', compact('data', 'pesan', 'file_yudisium'));

      } else {
        return Redirect::to("/");
      }
   }

   public function biodata(){
    
      if (Session::get('nim')==true){
  
        $nim = Session::get('nim');
        $data = TabelWisudawan::where('NIM', '=', ($nim))
              ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
              ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')->get();
        $agama  = \App\TabelAgama::all();
        $prodi  = \App\TabelUnit::where('unit.KETERANGAN_UNIT','prodi')->get(['ID_UNIT', 'UNIT']);
     
        return View::make('mahasiswa.biodata', compact('data', 'agama', 'prodi'));

      } else {
        return Redirect::to("/");
      }
   }

   public function updateBiodata(Request $request) {

        $ranpass = $this->randompassword();
        $idjadwalyudisium = $this->getJadwalyudisium();

        date_default_timezone_set('asia/jakarta');
        $date = date('Y-m-d');
        $datetime = date('Y-m-d h:i:sa');

        // $nim              = Input::get('nim');
        $namamahasiswa    = Input::get('namamahasiswa');
        $prodi            = Input::get('prodi');
        $tglterdaftar     = Input::get('tglterdaftar');
        $ipk              = Input::get('ipk');
        $elpt             = Input::get('elpt');
        $bidangilmu       = Input::get('bidangilmu');
        $judulpenelitihan = Input::get('judulpenelitihan');
        $dosenpembimbing1 = Input::get('dosenpembimbing1');
        $dosenpembimbing2 = Input::get('dosenpembimbing2');
        $tempatlahir      = Input::get('tempatlahir');
        $tanggallahir     = Input::get('tanggallahir');
        $agama            = Input::get('agama');
        $jeniskelamin     = Input::get('jeniskelamin');
        $alamat           = Input::get('alamat');
        $telpon           = Input::get('telpon');

        $namaortu   = Input::get('namaortu');
        $alamatortu = Input::get('alamatortu');
        $telponortu = Input::get('telponortu');

        $input = Input::all();

        // $nimnull = TabelWisudawan::all()->where('NIM', ($nim));
        $nim =  Session::get('nim');

        $nimapprove = DB::table('wisudawan')
                        ->where('NIM', ($nim))
                        ->where('VERIFIKASI', '=', '0')
                        ->get(['NIM', 'VERIFIKASI']);


        if ($nimapprove == true) {

          DB::table('wisudawan')->where('NIM', $nim)
          ->update([
                'NAMA'               => $namamahasiswa,
                'ID_UNIT'            => $prodi,
                'ID_JADWAL_YUDISIUM' => $idjadwalyudisium, 
                'ID_AGAMA'           => $agama,
                'PASSWORD_TEMP'      => $ranpass,
                'JENIS_KELAMIN'      => $jeniskelamin,
                'TGL_TERDAFTAR'      => $tglterdaftar,
                'TGL_LULUS'          => 0000-00-00,
                'IPK'                => $ipk,
                'ELPT'               => $elpt,
                'BIDANG_ILMU'        => $bidangilmu,
                'JUDUL_SKRIPSI'      => $judulpenelitihan,
                'DOSEN_PEMBIMBING_1' => $dosenpembimbing1,
                'DOSEN_PEMBIMBING_2' => $dosenpembimbing2,
                'TEMPAT_LAHIR'       => $tempatlahir,
                'TANGGAL_LAHIR'      => $tanggallahir,
                'ALAMAT'             => $alamat,
                'TELPON'             => $telpon,
                'NAMA_ORTU'          => $namaortu,
                'ALAMAT_ORTU'        => $alamatortu,
                'TELPON_ORTU'        => $telponortu,
                'VERIFIKASI'         => "0",
                'VERIFIKASI_AK'      => "0",
                // 'VERIFIKASI_KM'      => "0",
                'TGL_DAFTAR_YUDISIUM'=> $datetime,           
                ]);
              
              return Redirect::to("/biodata")->with('register_success', ' <b>Data berhasil disimpan! </b>');
        
        } else {
            return Redirect::to("/biodata")->withInput()->with('register_danger2', ' <b>Oops...! </b> Anda sudah diapprove, biodata tidak bisa diubah.');
        } 

    }

   public function fileyudisium(){
    
      if (Session::get('nim')==true){
  
        $nim = Session::get('nim');
        $data = TabelWisudawan::where('NIM', '=', ($nim))
              ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
              ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')->get();

        $fy =TabelFileYudisium::where('STATUS', '=', '1')->where('jadwal_yudisium.STATUS_JADWAL_YUDISIUM', '=', '2')
            ->join('jadwal_yudisium', 'file_yudisium.ID_JADWAL_YUDISIUM', '=', 'jadwal_yudisium.ID_JADWAL_YUDISIUM')->get();
     
        return View::make('mahasiswa.fileyudisium', compact('data', 'fy'));

      } else {
        return Redirect::to("/");
      }
   }

    public function getFilex($file_name)
    {
        // $this->$client = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_','yudisiumfst');
        // $this->$client = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_', 'yudisiumfst', null);
        $this->client = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_', 'wisudafst', null);
        $this->filesystem = new Filesystem(new Dropbox($client, '/yudisiumfst'));

        try{
            $file = $this->filesystem->read($file_name);
        }catch (\Dropbox\Exception $e){
            return Response::json("{'message' => 'File not found'}", 404);
        }

        $response = Response::make($file, 200);

        return $response;

    }

    public function getFile($file, DropboxStorageRepository $connection)
    {
        // $this->$client = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_', 'yudisiumfst');
        $dbxClient = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_', 'yudisiumfst');
        $this->filesystem = new Filesystem(new Dropbox($dbxClient, '/yudisiumfst'));

        try{
            $file = $this->filesystem->read($file);
        }catch (\Dropbox\Exception $e){
            return Response::json("{'message' => 'File not found'}", 404);
        }

        $response = Response::make($file, 200);

        return $response;

        // $dbxClient = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_', 'yudisiumfst');
        // // //download
        // $f = fopen('private/uploads/files/'.$file.'', "w+b");
        // $fileMetadata = $dbxClient->getFile('/'.$file.'',$f);
        // fclose($f);
        // print_r($fileMetadata);
        // return Redirect::to(url('private/uploads/files/'.$file_name.''));

    }

     public function uploadfileyudisium(DropboxStorageRepository $connection, Googl $googl, Request $request) {

        $cloud = TabelCloudStorage::where('STATUS_CLOUD', '=', '1')->orderBy('ID_CLOUD', 'desc')->skip(0)->take(1)->get(['ID_CLOUD']);

        foreach ($cloud as $idcloud) {
            $idstorage = $idcloud->ID_CLOUD;
        }

        $nim    = Input::get('nim');
        $fy     = Input::get('fy');
        $fileyudisium   = Input::get('fileyudisium');

        $NAMA_FILE  = TabelFileYudisium::where('file_yudisium.ID_FILE','=',$fy)->pluck('NAMA_FILE');
        $INISIAL    = TabelFileYudisium::where('file_yudisium.ID_FILE','=',$fy)->pluck('INISIAL');

        $filenull   = TabelDetailFile::where('NIM', '=', ($nim))->where('ID_FILE', '=', ($fy))->get(['NIM', 'ID_FILE']);

        $nimverifikasi = DB::table('wisudawan')
                        ->where('NIM', ($nim))
                        ->where('VERIFIKASI', '=', '1')
                        ->get(['NIM', 'VERIFIKASI']); 
        
        if ($idstorage == '1') {
            // return 'Dropbox';

            if ($filenull->count() >0){
                // return 'ada';
                if ($nimverifikasi == true) {
                    // return "file tidak bisa diupdate";
                    return response()->json([
                               'success'  => false,
                               'data' => ['Maaf! Anda sudah diapprove TU prodi, anda tidak bisa melakukan upload.']
                               ]);
                } else {
                    // return "update";
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
                                    'KETERANGAN'    => $NAMA_FILE,
                                    'ID_CLOUD'      => '1',
                                    ));

                            return response()->json([
                               'success'  => true,
                               'data' => ['File update has uploaded!.']
                               ]);

                        } catch (\Exception $e) {
                            
                            //upload file to server
                            $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                            Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                            DB::table('detail_file')
                                ->where('NIM', $nim)
                                ->where('ID_FILE', $fy)
                                ->update(array(
                                    'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                    'KETERANGAN'    => $NAMA_FILE,
                                    'ID_CLOUD'      => '1',
                                    ));

                            return response()->json([
                               'success'  => true,
                               'data' => ['File update has uploaded!.']
                               ]);
                        }
                    } 
                    else {
                        return response()->json([
                           'success'  => false,
                           'data' => ['File not present.']
                           ]);
                    }
                }
                  
            } else {
            
                if ($nimverifikasi == true) {
                    // return "file tidak bisa diupdate";
                    return response()->json([
                               'success'  => false,
                               'data' => ['Maaf! Anda sudah diapprove TU prodi, anda tidak bisa melakukan upload.']
                               ]);
                } else {
                    // return 'inser';
                    if (Input::hasFile('fileyudisium')) {
                                
                        $fileyudisium     = Input::file('fileyudisium');
                        try {
                            //upload file to dropbox
                            $filesystem = $connection->getConnection();
                            $filesystem->put($INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension(), File::get($fileyudisium));
                            //upload file to server
                            $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                            Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                            DB::table('detail_file')->insert([
                                'NIM'           => $nim,
                                'ID_FILE'       => $fy,
                                'ID_CLOUD'      => '1',
                                'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                'KETERANGAN'    => $NAMA_FILE,
                                ]);

                            return response()->json([
                               'success'  => true,
                               'data' => ['File has uploaded!.']
                               ]);

                        } catch (\Exception $e) {
                
                            //upload file to server
                            $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                            Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                            DB::table('detail_file')->insert([
                                'NIM'           => $nim,
                                'ID_FILE'       => $fy,
                                'ID_CLOUD'      => '1',
                                'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                'KETERANGAN'    => $NAMA_FILE,
                                ]);

                            return response()->json([
                               'success'  => true,
                               'data' => ['File has uploaded!.']
                               ]);
                        }

                    } 
                    
                    else {
                        return response()->json([
                           'success'  => false,
                           'data' => ['File not present.']
                           ]);
                    }

                }
            }


        } else {
            // return 'Google Drive';

            if ($filenull->count() >0){
                // return 'ada';
                if ($nimverifikasi == true) {
                    // return "file tidak bisa diupdate";
                    return response()->json([
                               'success'  => false,
                               'data' => ['Maaf! Anda sudah diapprove TU prodi, anda tidak bisa melakukan upload.']
                               ]);
                } else {
                    // return "update";
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
                                    'KETERANGAN'    => $NAMA_FILE,
                                    'ID_CLOUD'      => '2',
                                    ));

                            return response()->json([
                               'success'  => true,
                               'data' => ['File update has uploaded!.']
                               ]);

                        } catch (\Exception $e) {
                            
                            //upload file to server
                            $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                            Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                            DB::table('detail_file')
                                ->where('NIM', $nim)
                                ->where('ID_FILE', $fy)
                                ->update(array(
                                    'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                    'KETERANGAN'    => $NAMA_FILE,
                                    'ID_CLOUD'      => '2',
                                    ));

                            return response()->json([
                               'success'  => true,
                               'data' => ['File update has uploaded!.']
                               ]);
                        }
                    } 
                    else {
                        return response()->json([
                           'success'  => false,
                           'data' => ['File not present.']
                           ]);
                    }
                }
                  
            } else {
            
                if ($nimverifikasi == true) {
                    // return "file tidak bisa diupdate";
                    return response()->json([
                               'success'  => false,
                               'data' => ['Maaf! Anda sudah diapprove TU prodi, anda tidak bisa melakukan upload.']
                               ]);
                } else {
                    // return 'inser';
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

                            DB::table('detail_file')->insert([
                                'NIM'           => $nim,
                                'ID_FILE'       => $fy,
                                'ID_CLOUD'      => '2',
                                'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                'KETERANGAN'    => $NAMA_FILE,
                                ]);

                            return response()->json([
                               'success'  => true,
                               'data' => ['File has uploaded!.']
                               ]);

                        } catch (\Exception $e) {
                
                            //upload file to server
                            $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                            Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                            DB::table('detail_file')->insert([
                                'NIM'           => $nim,
                                'ID_FILE'       => $fy,
                                'ID_CLOUD'      => '2',
                                'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                                'KETERANGAN'    => $NAMA_FILE,
                                ]);

                            return response()->json([
                               'success'  => true,
                               'data' => ['File has uploaded!.']
                               ]);
                        }

                    } 
                    
                    else {
                        return response()->json([
                           'success'  => false,
                           'data' => ['File not present.']
                           ]);
                    }

                }
            }

        }
        
    }


    public function uploadfileyudisiumBackup(DropboxStorageRepository $connection) {


        $nim    = Input::get('nim');
        $fy    = Input::get('fy');
        $fileyudisium     = Input::get('fileyudisium');
        // return Input::get('fileyudisium');

        $NAMA_FILE  = TabelFileYudisium::where('file_yudisium.ID_FILE','=',$fy)
                ->pluck('NAMA_FILE');
        $INISIAL  = TabelFileYudisium::where('file_yudisium.ID_FILE','=',$fy)
                ->pluck('INISIAL');

        $filenull = TabelDetailFile::where('NIM', '=', ($nim))->where('ID_FILE', '=', ($fy))->get(['NIM', 'ID_FILE']);

        $nimverifikasi = DB::table('wisudawan')
                        ->where('NIM', ($nim))
                        ->where('VERIFIKASI', '=', '1')
                        ->get(['NIM', 'VERIFIKASI']); 
        
        if ($filenull->count() >0){
          // return 'ada';
          if ($nimverifikasi == true) {
            // return "file tidak bisa diupdate";
            return response()->json([
                       'success'  => false,
                       'data' => ['Maaf! Anda sudah diapprove TU prodi, anda tidak bisa melakukan upload.']
                       ]);
          } else {
            // return "update";
            if (Input::hasFile('fileyudisium')) {
                $fileyudisium     = Input::file('fileyudisium');

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

                return response()->json([
                   'success'  => true,
                   'data' => ['File update has uploaded!.']
                   ]);
            } 
            else{
                return response()->json([
                   'success'  => false,
                   'data' => ['File not present.']
                   ]);
            }
          }
          
        } else {
          if ($nimverifikasi == true) {
            // return "file tidak bisa diupdate";
            return response()->json([
                       'success'  => false,
                       'data' => ['Maaf! Anda sudah diapprove TU prodi, anda tidak bisa melakukan upload.']
                       ]);
          } else {
            // return 'inser';
            if (Input::hasFile('fileyudisium')) {
                $fileyudisium     = Input::file('fileyudisium');

                //upload file to dropbox
                            $filesystem = $connection->getConnection();
                            $filesystem->put($INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension(), File::get($fileyudisium));
                //upload file to server
                $fileyudisium= $INISIAL.$nim. '.' .$fileyudisium->getClientOriginalExtension();
                Input::file('fileyudisium')->move(base_path().'/uploads/files', $fileyudisium);

                DB::table('detail_file')->insert([
                    'NIM'           => $nim,
                    'ID_FILE'       => $fy,
                    'FILE_ALUMNI'   => $INISIAL.$nim.'.pdf',
                    'KETERANGAN'    => $NAMA_FILE,
                    ]);

                return response()->json([
                   'success'  => true,
                   'data' => ['File has uploaded!.']
                   ]);
            } 
            else{
                return response()->json([
                   'success'  => false,
                   'data' => ['File not present.']
                   ]);
            }
          }
        }
    }

    public function formsuratbebaspinjamalat(){
    
      if (Session::get('nim')==true){
  
        $nim = Session::get('nim');
        $data = TabelWisudawan::where('NIM', '=', ($nim))
              ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
              ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')->get();
        $agama  = \App\TabelAgama::all();
        $prodi  = \App\TabelUnit::where('unit.KETERANGAN_UNIT','prodi')->get(['ID_UNIT', 'UNIT']);
     
        return View::make('mahasiswa.formbebaspinjam', compact('data', 'agama', 'prodi'));

      } else {
        return Redirect::to("/");
      }
   }

    public function suratbebaspinjamalat() {


        if (Session::get('nim')==true) {

            $nim = Session::get('nim');
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

            $data = DB::Table('wisudawan','unit','agama')
                      ->where('wisudawan.NIM','=',$nim)
                      ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                      ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')
                      ->get();
                      // return $data;

          foreach ($data as $dataa) {
              # code...
              $NIM = $dataa->NIM;
              $NAMA = $dataa->NAMA;
              $ID_UNIT = $dataa->ID_UNIT;
              $UNIT = $dataa->UNIT;
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

            $PRODI_UP = strtoupper($UNIT);

            $ID_DEPARTEMEN = TabelUnit::where('ID_UNIT','=',$ID_UNIT)
                        ->pluck('UNI_ID_UNIT');
            $DEPARTEMEN = TabelUnit::where('UNI_ID_UNIT','=',$ID_DEPARTEMEN)
                        ->pluck('UNIT');
            $DEPARTEMEN_UP = strtoupper($DEPARTEMEN);

            $JENJANG = explode(' ', $UNIT);
                if ($JENJANG[0] = 'S1') {
                    $JENJANG = 'Sarjana';
                } else if ($JENJANG[0] = 'S2') {
                    $JENJANG = 'Magister';
                } else if ($JENJANG[0] = 'S3') {
                    $JENJANG = 'Doktor';
                }


            $TANGGAL_UJIAN = Input::get('tglujian');
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
                            <b>'.$DEPARTEMEN_UP.'<br>
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
                                    <td align="left" width="30"><font size="3" >NAMA</font></td>
                                    <td align="left" width="0"><font size="3" >:</font>
                                    </td>
                                    <td align="left" width="70"><font size="3" ><b> '.$NAMA.'  </font></td>
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
                            <font size="3" >Petugas Laboratorium<br>'.$DEPARTEMEN.' FSaintek Unair</font></p>
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
                            <font size="3" >Petugas Perpustakaan<br>'.$DEPARTEMEN.' FSaintek Unair</font></p>
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

    public function printFormDataLulusan() {
    
        $nim = Session::get('nim');
        $idjabatan = Session::get('jabatan');

        if (Session::get('nim') == $nim || $idjabatan == "2" || $idjabatan == "4") {

 
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
          $data = DB::Table('wisudawan','unit','agama')
                      ->where('wisudawan.NIM','=',$nim)
                      ->join('unit','wisudawan.ID_UNIT','=','unit.ID_UNIT')
                      ->join('agama','wisudawan.ID_AGAMA','=','agama.ID_AGAMA')
                      ->get();

          foreach ($data as $dataa) {
              $NIM = $dataa->NIM;
              $NAMA = $dataa->NAMA;
              $UNIT = $dataa->UNIT;
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


          if ($JENIS_KELAMIN == "1") {
            $JENIS_KELAMIN = "Laki-laki";
          } else if ($JENIS_KELAMIN == "2"){
            $JENIS_KELAMIN = "Perempuan";
          }
          

          $pdf = \App::make('dompdf.wrapper');

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
                      <td width="36%"><font size="15px"> Nim </td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$NIM.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Nama </td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$NAMA.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Fakultas</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> Sains dan Teknologi</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Program Studi</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$UNIT.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Tgl. Terdaftar Di Unair</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$TGL_TERDAFTAR.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Status Mahasiswa</td>
                      <td width="2%"> : </td>
                      <td width="62%"> <img src="private/a.png" width="15" height="15"><font size="2"> Ikut Wisuda</td>
                  </tr>
                  <tr >
                      <td width="36%" rowspan="2"> </td>
                      <td width="2%"> </td>
                      <td width="62%"> <img src="private/a.png" width="15" height="15"><font size="2"> Cetak Ijasah</td>
                  </tr>
                  <tr >
                      <td width="2%"> </td>
                      <td width="62%" size="1"> <img src="private/a blank.png" width="15" height="15"><font size="2"> Melanjutkan Profesi (Khusus untuk FK, FKG, FE-akuntansi, FF, FKH, Fpsi)</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Tanggal Lulus</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$TGL_LULUS.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> No. Urut Ijasah</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$NO_IJAZAH.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> IPK</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$IPK.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Skor TOEFL</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$ELPT.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Bidang Ilmu</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$BIDANG_ILMU.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Judul Skripsi/Tesis/Desertasi</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="14px"> '.$JUDUL_SKRIPSI.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Dosen Pembimbing 1</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$DOSEN_PEMBIMBING_1.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Dosen Pembimbing 2</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$DOSEN_PEMBIMBING_2.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Tempat, Tanggal Lahir</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$TEMPAT_LAHIR.', '.$TANGGAL_LAHIR.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Agama</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$AGAMA.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Jenis Kelamin</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$JENIS_KELAMIN.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Alamat Tinggal Mahasiswa</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="14px"> '.$ALAMAT.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Telpon/Handphone Mahasiswa</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$TELPON.'</td>
                  </tr>
                  <tr >
                      <td width="36%"> </td>
                      <td width="2%"> </td>
                      <td width="62%"> </td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Nama Orang Tua</td>
                      <td width="2%"> : </td>
                      <td width="62%" ><font size="15px"> '.$NAMA_ORTU.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Alamat Tinggal Orang Tua</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="14px"> '.$ALAMAT_ORTU.'</td>
                  </tr>
                  <tr >
                      <td width="36%"><font size="15px"> Telpon/Handphone Orang Tua</td>
                      <td width="2%"> : </td>
                      <td width="62%"><font size="15px"> '.$TELPON_ORTU.'</td>
                  </tr>
              </table>

              <table width="100%" border="0">
                  <tr>
                      <td width="2" align="left">
                      </td>
                      <td width="28" align="center">
                          <table>
                              <tr>
                                  <td align="center"><font size="12px">Foto dilakukan di <br> Gedung Rektorat <br> Lt.1 bagian <br> Registrasi <br> Direktorat <br> Pendidikan</font>
                                  </td>
                              </tr>
                          </table>
                      </td>
                      <td width="20" align="left">

                      <td width="2" align="left">
                      </td>
                      <td width="48" align="left">
                          <p style="text-align: justify; line-height:100%;" >
                          <font size="15px" >Surabaya, '.$result.'</font></p>
                          <br>
                          <br>
                          <P style="text-decoration:underline;"><font size="15px" > '.$NAMA.' </p>
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
          return $pdf->stream('(a)'.$NIM.'.pdf');
          
        } else {
            return redirect('logout');
        }
    }




}
 