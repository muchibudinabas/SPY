<?php
use Illuminate\Support\Facades\Mail;
use App\Make;
use App\Http\Controllers\Profile;
use App\TabelUserAccount;
use App\TabelProdi; //<-- dont forget this
use App\TabelFileYudisium;
use App\TabelDetailFile;
use App\TabelAlumni;
use App\TabelUnit;



use Carbon\Carbon;
use App\TabelResetPassword;
use App\TabelCobaValidasi;
use App\TabelPeriodeWisuda;
use App\TabelJadwalYudisium;
use Dropbox\Client;

use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;

use Illuminate\Support\Facades\Hash;

// This is where the user can see a login button for logging into Google
Route::get('/google', 'HomeController@index');

// This is where the user gets redirected upon clicking the login button on the home page
Route::get('/googlelogin', 'HomeController@login');

// Shows a list of things that the user can do in the app
Route::get('/googledashboard', 'AdminController@index');

Route::get('/uploadgoogle', 'AdminController@upload');
Route::post('/uploadgoogle', 'AdminController@doUpload');


Route::get('files/{id}', function ($file_name) {
    // return 'hehe'.$id; 
    $dbxClient = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_', 'yudisiumfst');
        // //download
        $f = fopen('private/uploads/files/'.$file_name.'', "w+b");
        $fileMetadata = $dbxClient->getFile('/'.$file_name.'',$f);
        fclose($f);
        // print_r($fileMetadata);
        return Redirect::to(url('private/uploads/files/'.$file_name.''));

      
});

Route::get('file/{id}', 'mahasiswa@getFile');


Route::get('/biodata', function()
{
    // $agama  = \App\TabelAgama::all();
    // $jk     = \App\TabelJenisKelamin::all();
    // $prodi  = \App\TabelProdi::all();
    // $periodewisuda = \App\TabelPeriodeWisuda::all();
    // $jadwalyudisium = \App\TabelJadwalYudisium::all();
    $fy = \App\TabelFileYudisium::where('file_yudisium.STATUS','=',1)
            ->get();

    return View::make('mahasiswa.biodata', compact('fy'));
});

Route::get ( '/crud', 'IndexController@readItems2' );
Route::post ( 'addItem', 'IndexController@addItem2' );
Route::post ( 'editItem', 'IndexController@editItem2' );
Route::post ( 'deleteItem', 'IndexController@deleteItem2' );

Route::get('split', function()
{
    $name = "Muchibudin";
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
    

});

Route::get('datetime', function()
{
    date_default_timezone_set('asia/jakarta');
    $date = date('Y-m-d h:i:sa');

    return $date;
});

Route::get('baru', function()
{
    $agama  = \App\TabelAgama::all();
    $jk     = \App\TabelJenisKelamin::all();
    $prodi  = \App\TabelProdi::all();
    $periodewisuda = \App\TabelPeriodeWisuda::all();
    $jadwalyudisium = \App\TabelJadwalYudisium::all();
    $fy = \App\TabelFileYudisium::where('file_yudisium.STATUS','=',1)
            ->get();

    return View::make('login2', compact('agama', 'jk', 'prodi', 'fy', 'periodewisuda', 'jadwalyudisium'));
});

Route::get('randompass', function()
{
    // str_random(8));
    $hashed_random_password = Hash::make(str_random(8));

    $hashedpassword = bcrypt($hashed_random_password);
    // $b = bcrypt(str_random($hashed_random_password));

    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pool1 = '0123456789';
    $pool2 = 'abcdefghijklmnopqrstuvwxyz';
    $pool3 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, 5).substr(str_shuffle(str_repeat($pool1, 5)), 0, 1).substr(str_shuffle(str_repeat($pool2, 5)), 0, 1).substr(str_shuffle(str_repeat($pool3, 5)), 0, 1);

    // return $hashedpassword;
});

Route::get('char', function()
{
    $dest = "206";

    // if ($dest) {
    //     return old(strtolower($dest))-96;
    // } else {
    //     return 0;
    // }

    // $destint = (int)$dest;
    $a = 1 + $dest;

    $substr = substr($dest, 0, 3);

    $substr4 = substr($dest,3,1);

    $plus = $substr4+1;

    if ($substr==200) {
        return $substr.$plus;
    } else {
        return $plus;
    }
    
    // return $substr4;
});

Route::get('charnim', function()
{
    $data = DB::table('alumni')->where('NIM', 'like', '082%')->orderBy('NIM', 'desc')->skip(0)->take(1)->get(['NIM']);

    // return $data;

    if ($data == null) {
        # code...
        $getdata = '082';
    } else {
        # code...
        foreach ($data as $data1) {
            // return $data1->NIM;
            $getdata= $data1->NIM;
        }
    }
    

    $substr = substr($getdata, 0, 3);
    $substr4 = substr($getdata,3,1);
    $plus = $substr4+1;


    if ($substr==$getdata) {
        return $substr.$plus;
    } else {
        return $substr.$plus;
    }

    // return $getdata;
});



//mulai project

Route::get('thanks', function()
{
    return View::make('thanks');
});
Route::get('tracking', function()
{
    return View::make('trackingblank');
});
Route::post('tracking', 'Yudisium@tracking');


Route::get('/', function()
{
    $agama  = \App\TabelAgama::all();
    $prodi  = \App\TabelUnit::where('unit.KETERANGAN_UNIT','prodi')->orderBy('UNIT', 'asc')->get(['ID_UNIT', 'UNIT']);
    $periodewisuda = \App\TabelPeriodeWisuda::where('STATUS_PERIODE_WISUDA', '=', '1')->skip(0)->take(1)->get();
    $jadwalyudisium = \App\TabelJadwalYudisium::where('STATUS_JADWAL_YUDISIUM', '=', '1')->orWhere('STATUS_JADWAL_YUDISIUM', '=', '2')->get();
    // $fy = \App\TabelFileYudisium::where('file_yudisium.STATUS','=',1)
    //         ->get();

    return View::make('login', compact('agama', 'prodi', 'periodewisuda', 'jadwalyudisium'));
});


Route::post('daftar_yudisium', 'mahasiswa@daftarYudisium');
Route::post('update_biodata', 'mahasiswa@updateBiodata');

Route::get('/dashboard', 'mahasiswa@dashboard');
Route::get('/biodata', 'mahasiswa@biodata');
Route::get('/fileyudisium', 'mahasiswa@fileyudisium');
Route::post('fileyudisium', 'mahasiswa@uploadfileyudisium');
Route::get('printformdatalulusan', 'mahasiswa@printFormDataLulusan');
Route::get('suratbebaspinjamalat', 'mahasiswa@formsuratbebaspinjamalat');
Route::post('suratbebaspinjamalat', 'mahasiswa@suratbebaspinjamalat');




//uploading file
// Route::post('fileyudisium',['as'=>'upload_file','uses'=>'Yudisium@fileyudisium']);
Route::get('users/dropdown/{id}', 'Yudisium@dropdown');
Route::get('excel', function()
{
//     Excel::create('Laravel Excel', function($excel) {

//     $excel->sheet('Excel sheet', function($sheet) {

//         $sheet->setOrientation('landscape');

//     });

// })->export('xls');


    $data = TabelAlumni::where('alumni.VERIFIKASI','=','1')
            ->where('alumni.VERIFIKASI_AK','=','1')
            ->join('prodi','alumni.ID_PRODI','=','prodi.ID_PRODI')
            ->join('jenis_kelamin','alumni.ID_JENIS_KELAMIN','=','jenis_kelamin.ID_JENIS_KELAMIN')
            ->join('agama','alumni.ID_AGAMA','=','agama.ID_AGAMA')
            ->join('ortu_alumni','alumni.NIM','=','ortu_alumni.NIM')

            ->get(['alumni.NIM','NAMA','PRODI','JENIS_KELAMIN','TGL_TERDAFTAR','TGL_LULUS','NO_IJAZAH','IPK','SKS','ELPT','SKP','BIDANG_ILMU','JUDUL_SKRIPSI','DOSEN_PEMBIMBING_1','DOSEN_PEMBIMBING_2','TEMPAT_LAHIR','TANGGAL_LAHIR','ALAMAT','TELPON','AGAMA','NAMA_ORTU','ALAMAT_ORTU','TELPON_ORTU']);


    Excel::create('Data Alumni', function($excel) use($data) {

        $excel->sheet('Sheetname', function($sheet) use($data) {

            $sheet->fromArray($data);

        });

    })->export('xls');

});
Route::get('getfy/{nim}/{x}', function ($nim, $x) {
// $nim = Session::get('nim');
    $datax = TabelDetailFile::where('NIM', $nim)->where('ID_FILE', $x);       

        if ($datax->count() > 0) {
            $data = array(['ID_FILE' => $x,
                            'NAMA_FILE' => 'File has uploaded',
                            'NAMA_FILE2' => ' ']);
            return $data;
        } else {
            $data = array(['ID_FILE' => 1,
                            'NAMA_FILE2' => 'Please upload file',
                            'NAMA_FILE' => ' ' ]);
            return $data;
        }

});
Route::get('getfy/{nim}', function ($nim) {
    // $nim = Session::get('nim');
    $data = TabelDetailFile::where('NIM','=',$nim)->get(['NIM','ID_FILE']);
    return json_encode($data);       

});
Route::get('getpilihfileyudisium/{nim}', function ($nim) {

    // $kota = DB::table('file_yudisium')
    //     ->join('detail_file','file_yudisium.ID_FILE','=','detail_file.ID_FILE')
    //     // ->join('detail_file','file_yudisium.ID_FILE','=','detail_file.ID_FILE')
    //     ->whereNotIn(TabelDetailFile::where('NIM', $nim))
    //     ->get();

    $pilihfileyudisium = DB::select("
                SELECT ID_FILE, NAMA_FILE 
                FROM file_yudisium 
                WHERE ID_FILE NOT IN 
                (SELECT ID_FILE FROM detail_file WHERE detail_file.NIM =" . $nim . ")");


    // $kota = DB::select("
    //     SELECT `ID_FILE`, `NAMA_FILE` FROM `file_yudisium` WHERE ID_FILE NOTIN (SELECT ID_FILE FROM detail_file WHERE detail_file.NIM ='13'");
    // $kota = TabelFileYudisium::whereIn('ID_FILE',function($query){
    //     $query->select('ID_FILE')
    //     ->from(with(new TabelDetailFile)->getTable())
    //     ->whereNotIn('NIM',['12']);
    // })->get();
    // $kota = TabelDetailFile::all();
    return $pilihfileyudisium;
});
Route::get('getkota/{nim}', function ($nim) {

    // $kota = DB::table('file_yudisium')
    //     ->join('detail_file','file_yudisium.ID_FILE','=','detail_file.ID_FILE')
    //     // ->join('detail_file','file_yudisium.ID_FILE','=','detail_file.ID_FILE')
    //     ->whereNotIn(TabelDetailFile::where('NIM', $nim))
    //     ->get();

    $kota = DB::select("
                SELECT ID_FILE, NAMA_FILE 
                FROM file_yudisium 
                WHERE ID_FILE NOT IN 
                (SELECT ID_FILE FROM detail_file WHERE detail_file.NIM =" . $nim . ") LIMIT 1");


    // $kota = DB::select("
    //     SELECT `ID_FILE`, `NAMA_FILE` FROM `file_yudisium` WHERE ID_FILE NOTIN (SELECT ID_FILE FROM detail_file WHERE detail_file.NIM ='13'");
    // $kota = TabelFileYudisium::whereIn('ID_FILE',function($query){
    //     $query->select('ID_FILE')
    //     ->from(with(new TabelDetailFile)->getTable())
    //     ->whereNotIn('NIM',['12']);
    // })->get();
    // $kota = TabelDetailFile::all();
    return $kota;
});
Route::get('getkota2', function () {

    $kota2  = \App\TabelAgama::all();
    // $kota2 ="dsad";
    return $kota2;
});

Route::post('login','Login@login');


Route::get('/home', 'Login@home');
Route::get('logout', 'Login@logout');

//menu kemahasiswaan
// Route::get('inputskp', 'Kemahasiswaan@inputSkp');
Route::get('inputskp', 'Kemahasiswaan@inputSkp');
Route::post('inputskp', 'Kemahasiswaan@inputSkpSave');
Route::get('dataskpmahasiswa', 'Kemahasiswaan@listYudisium');

Route::get('inputskp/edit/{id}', 'Kemahasiswaan@edit');
Route::post('inputskp/inputSkp/{id}', 'Kemahasiswaan@editSkp');
Route::post('inputskp/delete/{id}', 'Kemahasiswaan@deleteSkp');
// Route::post('inputskp/verifikasiKm/{id}', 'KemahasiswaanController@verifikasiKm');

Route::get('datawisudawankm', 'Kemahasiswaan@dataWisudawan');

//menu akademik
Route::get('inputnoijazah', 'Akademik@listYudisium');
Route::get('inputnoijazah/edit/{id}', 'Akademik@edit');
Route::post('inputnoijazah/inputNoIjazah/{id}', 'Akademik@inputNoIjazah');
Route::post('inputnoijazah/verifikasiAk/{id}', 'Akademik@verifikasiAk');
Route::get('datawisudawanak', 'Akademik@dataWisudawan');
Route::get('datawisudawanak/{id}', 'Akademik@dataWisudawanPeriodeWisuda');


// MENU Jadwal Yudisium
// sub menu periode wisuda akademik
Route::get('/periodewisuda', 'Akademik@periodeWisudaa');
Route::post('periodewisuda/store', 'Akademik@storePeriodewisuda');
Route::get('periodewisuda/edit/{id}', 'Akademik@periodeWisuda');
Route::post('periodewisuda/periodeWisuda/{id}', 'Akademik@updatePeriodewisuda');


// sub menu jadwal yudisium akademik
Route::get('/jadwalyudisium', 'Akademik@jadwalYudisium');
Route::post('jadwalyudisium/store', 'Akademik@storeJadwalyudisium');
Route::get('jadwalyudisium/edit/{id}', 'Akademik@editJadwalyudisium');
Route::post('jadwalyudisium/update/{id}', 'Akademik@updateJadwalyudisium');
Route::post('jadwalyudisium/delete/{id}', 'AkademikController@destroyJadwalyudisium');
// sub menu file yudisium akademik
Route::get('/file_yudisium', 'Akademik@file_yudisium');//sementara hidden
Route::post('fileyudisium/store', 'Akademik@storeFileyudisium');
Route::get('fileyudisium/edit/{id}', 'AkademikController@fileyudisium');
Route::post('fileyudisium/update/{id}', 'Akademik@updateFileyudisium');
Route::post('fileyudisium/delete/{id}', 'Akademik@destroyFileyudisium');

Route::get('exportexcel', 'Akademik@exportExcel');

Route::get('tambahakun', 'Akademik@addAkun');
Route::post('tambahakun', 'Akademik@addAkunSave');

Route::get('/getunit', function () {
    $id = Input::get('id');
    if ($id == 1 || $id == 3 ||$id == 4) {
        // return '134';
        $data = TabelUnit::where('KETERANGAN_UNIT', '=', 'Fakultas')->get();
        return $data;
    } elseif ($id == 2) {
        // return '2';
        $data = TabelUnit::where('KETERANGAN_UNIT', '=', 'Prodi')->get();
        return $data;
    }
});
Route::get('kelolaakun', 'Akademik@kelolaAkun');
Route::get('kelolaakun/edit/{id}', 'Akademik@kelolaAkunedit');
Route::post('kelolaakun/save/{id}', 'Akademik@kelolaAkunsave');
Route::get('ubahpassword_ak', 'Akademik@ubahPasswordAkun');
Route::post('ubahpassword_ak/save/{id}', 'Akademik@ubahPasswordAkunsave');

Route::get('penyimpananfile', 'Akademik@cloudstorage');
Route::post('penyimpananfile', 'Akademik@saveCloudStorage');




Route::get('profile', 'Akademik@profile');
// Route::post('ubahpassword', 'AkademikController@ubahPassword');
Route::post('ubahPassword', 'Akademik@ubahPassword');


//HALAMAN PRODI
Route::get('/approve', 'Prodi@listYudisium');
Route::get('approve/edit/{id}', 'Prodi@edit');
Route::post('approve/approvePendaftaran/{id}', 'Prodi@approvePendaftaran');
//aprove baru
Route::get('approvePendaftaran/{id}', 'Prodi@approvePendaftaran');
Route::post('approvePendaftaran/{id}', 'Prodi@approvePendaftaran');
Route::post('cancelPendaftaran/{id}', 'Prodi@cancelPendaftaran');
Route::post('disapprovePendaftaran/{id}', 'Prodi@disapprovePendaftaran');

//pesan
Route::get('pesan/{nim}/{idfile}', 'Prodi@pesan');
Route::post('pesan/{nim}/{idfile}', 'Prodi@pesanPost');
Route::get('upload/{nim}/{idfile}', 'Prodi@upload');
Route::post('upload/{nim}/{idfile}', 'Prodi@uploadPost');

Route::post('approve/delete/{id}', 'Prodi@cancel');
Route::post('detail_mhs/delete/{id}', 'Prodi@cancel');
Route::get('/onprocess', 'Prodi@onprocess');
Route::get('exportexceldataalumniprodionprocess', 'Prodi@exportExcelOnProcess');

//MENU data wisudawan
Route::get('datawisudawan', 'Prodi@dataWisudawan');
Route::get('datawisudawan/{id}', 'Prodi@dataWisudawanPeriodeWisuda');
Route::get('exportexceldataalumniprodi', 'Prodi@exportExcel');

//menu umum (prodi dan akademik)
Route::get('detail_mhs/{nim}', 'Akademik@detailMahasiswa');
Route::get('mhs_onprocess/{nim}', 'Prodi@detailMahasiswaOnproccess');
Route::get('mhs_wisudawan/{nim}', 'Prodi@detailMahasiswaWisudawan');
Route::get('mhs_wisudawanak/{nim}', 'Akademik@detailMahasiswaWisudawan');

// Route::get('cetakformpendaftaranyudisium', 'AkademikController@cetakFormDataLulusan');

//MENU cetak surat bebas pinjam alat prodi
Route::get('cetaksuratbebaspinjamalat', 'ProdiController@cetakSurat');
Route::post('cetaksuratbebaspinjamalat', 'ProdiController@postCetakSurat');

//ubah password prodi

// Route::get('kelolaakun/edit/{id}', 'Akademik@kelolaAkunedit');
// Route::post('kelolaakun/save/{id}', 'Akademik@kelolaAkunsave');
Route::get('ubahpassword_prodi', 'Prodi@ubahPasswordAkun');
Route::post('ubahpassword_prodi/save/{id}', 'Prodi@ubahPasswordAkunsave');


// Route::get('printformdatalulusan', 'AkademikController@cetakFormDataLulusan');


//HALAMAN RUANG BACA
//MENU daftar anggota
Route::get('daftaranggota', 'RuangBaca@daftarAnggota');
Route::post('daftaranggota/store', 'RuangBaca@storeDaftarAnggota');
Route::get('daftaranggota/edit/{id}', 'RuangBaca@editDaftarAnggota');
Route::post('daftaranggota/update/{id}', 'RuangBaca@updateDaftarAnggota');
Route::post('daftaranggota/delete/{id}', 'RuangBaca@destroyDaftarAnggota');

//MENU pinjam buku
Route::get('pinjambuku', 'RuangBaca@pinjamBuku');
Route::post('pinjambuku/store', 'RuangBaca@storePinjamBuku');
Route::get('pinjambuku/edit/{id}', 'RuangBacaController@editPinjamBuku');
Route::post('pinjambuku/kembalibuku/{id}', 'RuangBaca@kembalikanBuku');
Route::get('detail_pinjam/{nim}/{id}', 'RuangBaca@detailPinjam');

//MENU history pinjam buku
Route::get('historypinjambuku', 'RuangBaca@historyPinjamBuku');
Route::get('exportexcelhistorypinjambuku', 'RuangBaca@exportExcel');

// MENU cetak surat ket bebas pinjam Ruang baca
Route::get('cetaksuratbebaspinjam', 'RuangBaca@cetakSurat');
Route::post('cetaksuratbebaspinjam', 'RuangBaca@postCetakSurat');
//end ruang baca

Route::post('cetakformBackUp', function(){
    
    $idmhs = Session::get('$idmhs');
 
    return  $idmhs;
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
                ->where('alumni.NIM','=',$nim)
                ->join('prodi','alumni.ID_PRODI','=','prodi.ID_PRODI')
                ->join('agama','alumni.ID_AGAMA','=','agama.ID_AGAMA')
                ->join('jenis_kelamin','alumni.ID_JENIS_KELAMIN','=','jenis_kelamin.ID_JENIS_KELAMIN')
                ->join('ortu_alumni','alumni.NIM','=','ortu_alumni.NIM')
                ->get();
   foreach ($data as $dataa) {
    $dataa->NIM =$nim;
       # code...
   }

    $pdf = App::make('dompdf.wrapper');

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
                            <td align="left"><font size="3" ><b> '.$nim.'  </font></td>
                        </tr>
                    </table>
                    <br>

                    <p style="text-align: justify; line-height:1.5;" >
                    <font size="3" >Sudah tidak mempunyai tanggungan peminjaman/ penggantian buku/ jurnal/ majalah milik ruang baca Fakultas Sains Teknologi Universitas Airlangga. Surat keterangan ini untuk digunakan sebagai kelengkapan persyaratan lulus Program  di Fakultas Sains Teknologi Universitas Airlangga.<br></font></p>
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
    return $pdf->stream();

});


