<?php
namespace App\Http\Controllers;
use Redirect;
use App\Gettabeluser;
use App\TabelUserAccount;
use App\TabelWisudawan;
use App\TabelPegawai;
use App\TabelJabatan;
use App\TabelUnit;




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
use App\Repositories\Googl;


class Login extends BaseController {

    public function login(Googl $googl) {
        $input = Input::all();
        $user = Input::get('username');
        $pass = Input::get('password');

        $data = TabelUserAccount::all()->where('USERNAME', ($user))->where('PASSWORD', md5($pass))->where('AKTIVASI','1');

        $datanim = TabelWisudawan::all()->where('NIM', ($user))->where('PASSWORD_TEMP', ($pass))->where('VERIFIKASI_AK','0');

        $nimexpired = TabelWisudawan::all()->where('NIM', ($user))->where('PASSWORD_TEMP', ($pass))->where('VERIFIKASI_AK','1');

        if ($data->count() > 0) {
            foreach ($data as $data1) {
                Session::put('username', $user);
                Session::put('nip', $data1->NIP);
                Session::put('image', $data1->IMAGE);
                Session::put('access', ("true"));

                session([
                    'user' => [
                        'token' => '{"access_token":"ya29.Ci-GAxwcH9khkwUvCjx3VD--qlGb6_Yc7GE5xlOpwMs7avT-koci4ILUm_vSYVxXTg","token_type":"Bearer","expires_in":3600,"id_token":"eyJhbGciOiJSUzI1NiIsImtpZCI6ImUzMjY2MWVlMTE0M2MzOTI3ZGQ5M2VjYTBhM2Y5MWI3MjE1Y2JkODUifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXRfaGFzaCI6IjRVa0l4Rm14elNCei1lUDVkSnJqU1EiLCJhdWQiOiIxMDE0MTIwMDY2NzIyLXNyMG5zbDgwaHNodDVwdWhpYnUyaXQ5MTJsamttNGR2LmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTE4MDc3NjA5NjE1Nzk3NzY3NTc4IiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF6cCI6IjEwMTQxMjAwNjY3MjItc3IwbnNsODBoc2h0NXB1aGlidTJpdDkxMmxqa200ZHYuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJoZCI6ImZzdC51bmFpci5hYy5pZCIsImVtYWlsIjoibXVjaGlidWRpbi5hYmFzLTEyQGZzdC51bmFpci5hYy5pZCIsImlhdCI6MTQ3NzMxMDQyMywiZXhwIjoxNDc3MzE0MDIzfQ.KbGAgjSKCFSoNZ6agH1jcMVwdWd2v1Q3d2RHOF8x4RXuVMz6mqfaN7VLFtTaY8ddNIgcg89aQmQV8-6G4DC_1XQP4jrNzXTawuCHOMh-vbrsGyiV1A-1-wE_Z1knQjrMS3GnkHnQXTNfWksFuBk2qpsvdN7IT5TaAzrm_Dhg-J2RAw4QFG5Epq5ieqVIgCAPrQOuyhPrP_1RWr1ehQpA1teY4DHlX8ISl7CQWBTsCGjfTXpRysalQdFgZAOq0JdIHv4LNf9z8z2SfROBU1toDXk7wXmQ3OTLn0EKKwEO5cdX1MMHt2kBYvoVV4nqopgOltoofUFDN1JaV1BakygX7A","refresh_token":"1\/j51h6cZrOhTp0QUTKhqeNJftkBb5eXQqx5AhcrO6b3E","created":1477310422}'
                    ]
                ]);
                
                return Redirect::to('/home')->with('warning', 'Login Sukses');
            
            }
        
        } else if ($datanim->count() > 0) {
            foreach ($datanim as $data1) {
                Session::put('nim', $user);
                Session::put('access', ("true"));

                session([
                    'user' => [
                        'token' => '{"access_token":"ya29.Ci-GAxwcH9khkwUvCjx3VD--qlGb6_Yc7GE5xlOpwMs7avT-koci4ILUm_vSYVxXTg","token_type":"Bearer","expires_in":3600,"id_token":"eyJhbGciOiJSUzI1NiIsImtpZCI6ImUzMjY2MWVlMTE0M2MzOTI3ZGQ5M2VjYTBhM2Y5MWI3MjE1Y2JkODUifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXRfaGFzaCI6IjRVa0l4Rm14elNCei1lUDVkSnJqU1EiLCJhdWQiOiIxMDE0MTIwMDY2NzIyLXNyMG5zbDgwaHNodDVwdWhpYnUyaXQ5MTJsamttNGR2LmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTE4MDc3NjA5NjE1Nzk3NzY3NTc4IiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF6cCI6IjEwMTQxMjAwNjY3MjItc3IwbnNsODBoc2h0NXB1aGlidTJpdDkxMmxqa200ZHYuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJoZCI6ImZzdC51bmFpci5hYy5pZCIsImVtYWlsIjoibXVjaGlidWRpbi5hYmFzLTEyQGZzdC51bmFpci5hYy5pZCIsImlhdCI6MTQ3NzMxMDQyMywiZXhwIjoxNDc3MzE0MDIzfQ.KbGAgjSKCFSoNZ6agH1jcMVwdWd2v1Q3d2RHOF8x4RXuVMz6mqfaN7VLFtTaY8ddNIgcg89aQmQV8-6G4DC_1XQP4jrNzXTawuCHOMh-vbrsGyiV1A-1-wE_Z1knQjrMS3GnkHnQXTNfWksFuBk2qpsvdN7IT5TaAzrm_Dhg-J2RAw4QFG5Epq5ieqVIgCAPrQOuyhPrP_1RWr1ehQpA1teY4DHlX8ISl7CQWBTsCGjfTXpRysalQdFgZAOq0JdIHv4LNf9z8z2SfROBU1toDXk7wXmQ3OTLn0EKKwEO5cdX1MMHt2kBYvoVV4nqopgOltoofUFDN1JaV1BakygX7A","refresh_token":"1\/j51h6cZrOhTp0QUTKhqeNJftkBb5eXQqx5AhcrO6b3E","created":1477310422}'
                    ]
                ]);
                
                return Redirect::to('/dashboard')->with('warning', 'Login Sukses');

            }
        } else if ($nimexpired->count() > 0) {
            return Redirect::to("/#login")->withInput()->with('warning', 'Anda sudah menjadi wisudawan, <br><b>Akun expired!</b>');
        } else {
            return Redirect::to("/#login")->withInput()->with('warning', 'Username or Password Incorrect');
        }

    }

    public function home() {

        if (Session::has('access')) {

            $nip = Session::get('nip');
            
            $data = TabelPegawai::where('NIP',$nip)->get();
            foreach ($data as $data1) {
                // $idjabatan = $data1->ID_JABATAN;
                // $idunit = $data1->ID_UNIT;
                Session::put('jabatan', $data1->ID_JABATAN);
                Session::put('idunit', $data1->ID_UNIT);
            }

            $idjabatan = Session::get('jabatan');
            $idunit = Session::get('idunit');

            if ($idjabatan == "1") {

                $data2  = DB::table('anggota_ruangbaca')
                    ->select(DB::raw('count(*) as nim_count, NIM_ANGGOTA'))
                    ->get();

                $data3  = DB::table('detail_pinjam_buku')
                    ->select(DB::raw('count(*) as pinjam_count, STATUS_PINJAM'))
                    ->where('STATUS_PINJAM', '=', 0)
                    ->get();

                $profile = TabelPegawai::where('NIP','=',$nip)
                        ->get();

                return view('ruangbaca.home', compact('data2', 'data3', 'profile'));

            } else if ($idjabatan == "2") {
                // return 'prodi';
                    $data2  = DB::table('wisudawan')
                    ->select(DB::raw('count(*) as verifikasi_count, VERIFIKASI'))
                    ->where('VERIFIKASI', '=', 0)
                    ->where('ID_UNIT', '=', $idunit)
                    ->whereNotNull('NAMA_ORTU')
                    ->get();

                    $dataprocess  = DB::table('wisudawan')
                    ->select(DB::raw('count(*) as verifikasi_count, VERIFIKASI'))
                    ->where('VERIFIKASI', '=', 1)
                    ->where('VERIFIKASI_AK', '=', 0)
                    ->where('ID_UNIT', '=', $idunit)
                    ->whereNotNull('NAMA_ORTU')
                    ->get();

                    $alumni  = DB::table('wisudawan')
                    ->select(DB::raw('count(*) as verifikasi_count, VERIFIKASI_AK'))
                    ->where('VERIFIKASI_AK', '=', 1)
                    ->where('ID_UNIT', '=', $idunit)
                    ->get();
                        
                    $profile = TabelPegawai::where('NIP','=',$nip)
                        ->get();

                    return View::make('prodi.home', compact('data2', 'dataprocess', 'alumni', 'profile'));

            } else if ($idjabatan == "3") {
                // return 'kemahasiswaan';  

                $skp  = DB::table('wisudawan')
                ->select(DB::raw('count(*) as verifikasi_count, NIM'))
                ->whereNull('SKP')
                ->where('VERIFIKASI_AK', '=', 0)
                ->get();

                $data2  = DB::table('wisudawan')
                ->select(DB::raw('count(*) as verifikasi_count, NIM'))
                ->whereNotNull('SKP')
                ->where('VERIFIKASI_AK', '=', 0)
                ->get();

                $alumni  = DB::table('wisudawan')
                    ->select(DB::raw('count(*) as verifikasi_count, VERIFIKASI_AK'))
                    // ->whereNotNull('SKP')
                    ->where('VERIFIKASI_AK', '=', 1)
                    ->get();

                $profile = TabelPegawai::where('NIP','=',$nip)
                        ->get();


                return view('kemahasiswaan.home', compact('skp', 'data2', 'alumni', 'profile'));
         
            } else if ($idjabatan == "4") {
                // return 'akademik';

                $data2  = DB::table('wisudawan')
                ->select(DB::raw('count(*) as verifikasi_count, VERIFIKASI'))
                ->where('VERIFIKASI', '=', 1)
                ->where('VERIFIKASI_AK', '=', 0)
                ->get();

                $user  = DB::table('user_account')
                    ->select(DB::raw('count(*) as verifikasi_count, USERNAME'))
                    ->get();

                $alumni  = DB::table('wisudawan')
                    ->select(DB::raw('count(*) as verifikasi_count, VERIFIKASI_AK'))
                    ->where('VERIFIKASI_AK', '=', 1)
                    ->get();
                    
                $profile = TabelPegawai::where('NIP','=',$nip)
                    ->get();
                return view('akademik.home', compact('data2', 'user', 'alumni', 'profile'));
            } 
       
        } else {
            return redirect('/logout');
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('');
    }
}
 