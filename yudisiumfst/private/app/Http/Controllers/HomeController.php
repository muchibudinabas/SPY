<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Googl;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }


    public function login(Googl $googl, Request $request)
    {
        // $client = $googl->client();
            session([
                'user' => [
                    'token' => '{"access_token":"ya29.Ci-GAxwcH9khkwUvCjx3VD--qlGb6_Yc7GE5xlOpwMs7avT-koci4ILUm_vSYVxXTg","token_type":"Bearer","expires_in":3600,"id_token":"eyJhbGciOiJSUzI1NiIsImtpZCI6ImUzMjY2MWVlMTE0M2MzOTI3ZGQ5M2VjYTBhM2Y5MWI3MjE1Y2JkODUifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXRfaGFzaCI6IjRVa0l4Rm14elNCei1lUDVkSnJqU1EiLCJhdWQiOiIxMDE0MTIwMDY2NzIyLXNyMG5zbDgwaHNodDVwdWhpYnUyaXQ5MTJsamttNGR2LmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTE4MDc3NjA5NjE1Nzk3NzY3NTc4IiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF6cCI6IjEwMTQxMjAwNjY3MjItc3IwbnNsODBoc2h0NXB1aGlidTJpdDkxMmxqa200ZHYuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJoZCI6ImZzdC51bmFpci5hYy5pZCIsImVtYWlsIjoibXVjaGlidWRpbi5hYmFzLTEyQGZzdC51bmFpci5hYy5pZCIsImlhdCI6MTQ3NzMxMDQyMywiZXhwIjoxNDc3MzE0MDIzfQ.KbGAgjSKCFSoNZ6agH1jcMVwdWd2v1Q3d2RHOF8x4RXuVMz6mqfaN7VLFtTaY8ddNIgcg89aQmQV8-6G4DC_1XQP4jrNzXTawuCHOMh-vbrsGyiV1A-1-wE_Z1knQjrMS3GnkHnQXTNfWksFuBk2qpsvdN7IT5TaAzrm_Dhg-J2RAw4QFG5Epq5ieqVIgCAPrQOuyhPrP_1RWr1ehQpA1teY4DHlX8ISl7CQWBTsCGjfTXpRysalQdFgZAOq0JdIHv4LNf9z8z2SfROBU1toDXk7wXmQ3OTLn0EKKwEO5cdX1MMHt2kBYvoVV4nqopgOltoofUFDN1JaV1BakygX7A","refresh_token":"1\/j51h6cZrOhTp0QUTKhqeNJftkBb5eXQqx5AhcrO6b3E","created":1477310422}'
                ]
            ]);

            return redirect('/uploadgoogle');
                // ->with('message', ['type' => 'success', 'text' => 'You are now logged in.']);

        // if ($request->has('code')) {

        //     // $client->authenticate($request->input('code'));
        //     // $token = $client->getAccessToken();

        //     // $plus = new \Google_Service_Plus($client);

        //     // $google_user = $plus->people->get('me');
        //     // $id = $google_user['id'];

        //     // $email = $google_user['emails'][0]['value'];
        //     // $first_name = $google_user['name']['givenName'];
        //     // $last_name = $google_user['name']['familyName'];

        //     session([
        //         'user' => [
        //             // 'email' => $email,
        //             'email' => 'muchibudin.abas-12@fst.unair.ac.id',
        //             // 'first_name' => $first_name,
        //             'first_name' => 'Muchibudin',

        //             // 'last_name' => $last_name,
        //             'last_name' => 'Abas',
        //             // 'token' => $token
        //             'token' => '{"access_token":"ya29.Ci-GAxwcH9khkwUvCjx3VD--qlGb6_Yc7GE5xlOpwMs7avT-koci4ILUm_vSYVxXTg","token_type":"Bearer","expires_in":3600,"id_token":"eyJhbGciOiJSUzI1NiIsImtpZCI6ImUzMjY2MWVlMTE0M2MzOTI3ZGQ5M2VjYTBhM2Y5MWI3MjE1Y2JkODUifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXRfaGFzaCI6IjRVa0l4Rm14elNCei1lUDVkSnJqU1EiLCJhdWQiOiIxMDE0MTIwMDY2NzIyLXNyMG5zbDgwaHNodDVwdWhpYnUyaXQ5MTJsamttNGR2LmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTE4MDc3NjA5NjE1Nzk3NzY3NTc4IiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF6cCI6IjEwMTQxMjAwNjY3MjItc3IwbnNsODBoc2h0NXB1aGlidTJpdDkxMmxqa200ZHYuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJoZCI6ImZzdC51bmFpci5hYy5pZCIsImVtYWlsIjoibXVjaGlidWRpbi5hYmFzLTEyQGZzdC51bmFpci5hYy5pZCIsImlhdCI6MTQ3NzMxMDQyMywiZXhwIjoxNDc3MzE0MDIzfQ.KbGAgjSKCFSoNZ6agH1jcMVwdWd2v1Q3d2RHOF8x4RXuVMz6mqfaN7VLFtTaY8ddNIgcg89aQmQV8-6G4DC_1XQP4jrNzXTawuCHOMh-vbrsGyiV1A-1-wE_Z1knQjrMS3GnkHnQXTNfWksFuBk2qpsvdN7IT5TaAzrm_Dhg-J2RAw4QFG5Epq5ieqVIgCAPrQOuyhPrP_1RWr1ehQpA1teY4DHlX8ISl7CQWBTsCGjfTXpRysalQdFgZAOq0JdIHv4LNf9z8z2SfROBU1toDXk7wXmQ3OTLn0EKKwEO5cdX1MMHt2kBYvoVV4nqopgOltoofUFDN1JaV1BakygX7A","refresh_token":"1\/j51h6cZrOhTp0QUTKhqeNJftkBb5eXQqx5AhcrO6b3E","created":1477310422}'
        //         ]
        //     ]);

        //     // return $email.$first_name.$last_name.$token;

        //     return redirect('/googledashboard')
        //         ->with('message', ['type' => 'success', 'text' => 'You are now logged in.']);

        // } else {
        //     $auth_url = $client->createAuthUrl();
        //     return redirect($auth_url);
        // }
   }
}