<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class DaftarYudisiumTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     // $this->assertTrue(true);
    // 	echo "strisfsfng";

    //     $this->visit('/')
    //      ->type('Kemahasiswaan', 'username')
    //      ->type('Kemahasiswaan2016', 'password')
    //      ->press('Log In')
    //      ->see('Kemahasiswaan');
    //      // ->seePageIs('/ssxsx');

    // }

   //  public function testDaftarYudisiumSuccess()
   //  {
   //      $this->visit('/')
			// ->type('141414141417', 'nim')
			// ->type('Budi', 'namamahasiswa')
			// ->select('7', 'prodi')
			// ->type('11-08-2012', 'tglterdaftar')
			// ->type('3.44', 'ipk')
			// ->type('567', 'elpt')
			// ->type('Rekayasa Sistem Informasi', 'bidangilmu')
			// ->type('Sistem pendaftaran yusidium', 'judulpenelitihan')
			// ->type('Pak Taufiq', 'dosenpembimbing1')
			// ->type('Bu Endah', 'dosenpembimbing2')
			// ->type('Surabaya', 'tempatlahir')
			// ->type('11-08-2012', 'tanggallahir')
			// ->select('1IS', 'agama')
			// ->select('1', 'jeniskelamin')
			// ->type('Surabaya', 'alamat')
			// ->type('085733543033', 'telpon')
			// ->type('Andi', 'namaortu')
			// ->type('Surabaya', 'alamatortu')
			// ->type('085733543033', 'telponortu')
			// ->press('Daftar')
			// ->see('Pendaftaran Yudisium Berhasil!');

   //  }

   //  public function testPernahDaftarYudisium()
   //  {
   //      $this->visit('/')
			// ->type('141414141414', 'nim')
			// ->type('Budi', 'namamahasiswa')
			// ->select('7', 'prodi')
			// ->type('11-08-2012', 'tglterdaftar')
			// ->type('3.44', 'ipk')
			// ->type('567', 'elpt')
			// ->type('Rekayasa Sistem Informasi', 'bidangilmu')
			// ->type('Sistem pendaftaran yusidium', 'judulpenelitihan')
			// ->type('Pak Taufiq', 'dosenpembimbing1')
			// ->type('Bu Endah', 'dosenpembimbing2')
			// ->type('Surabaya', 'tempatlahir')
			// ->type('11-08-2012', 'tanggallahir')
			// ->select('1IS', 'agama')
			// ->select('1', 'jeniskelamin')
			// ->type('Surabaya', 'alamat')
			// ->type('085733543033', 'telpon')
			// ->type('Andi', 'namaortu')
			// ->type('Surabaya', 'alamatortu')
			// ->type('085733543033', 'telponortu')
			// ->press('Daftar')
			// ->see('Anda dalam proses pendaftaran yudisium, silahkan menemui TU Prodi untuk meminta verifikasi pendaftaran yudisium dengan membawa <em>(hardcopy)</em> persyaratan yudisium.');

   //  }

   //  public function testApprovePendaftaranSuccess()
   //  {
   //      $this->visit('/')
			// ->type('Sisfor01', 'username')
			// ->type('Sisfor01', 'password')
			// ->press('Log In')
			// ->seePageIs('/home')
			// ->visit('/approve')
			// ->seePageIs('/approve')
			// ->visit('/detail_mhs/141414141414')
			// ->seePageIs('/detail_mhs/141414141414')
			// ->click('ApproveButton')
			// ->see('Approve pendaftaran berhasil');
   //  }

   //  public function testInputSKP()
   //  {
   //      $this->visit('/')
			// ->type('Kemahasiswaan1', 'username')
			// ->type('Kemahasiswaan1', 'password')
			// ->press('Log In')
			// ->seePageIs('/home')
			// ->visit('/inputskp')
			// ->seePageIs('/inputskp')
			// ->type('141414141414', 'nim[141414141414]')
			// ->type('100', 'skp[141414141414]')
			// ->press('Save')
			// ->see('Data berhasil disimpan.');
   //  }

	// //ubah
 //    public function testInputSKPFailed()
 //    {
 //        $this->visit('/')
	// 		->type('Kemahasiswaan1', 'username')
	// 		->type('Kemahasiswaan1', 'password')
	// 		->press('Log In')
	// 		->seePageIs('/home')
	// 		->visit('/inputskp')
	// 		->seePageIs('/inputskp')
	// 		->type('141414141417', 'nim[141414141417]')
	// 		->type('xxx', 'skp[141414141417]')
	// 		->press('Save')
	// 		->see('Data berhasil disimpan.');
 //    }

   //  public function testInputNoIjazah()
   //  {
   //      $this->visit('/')
			// ->type('Akademik1', 'username')
			// ->type('Akademik1', 'password')
			// ->press('Log In')
			// ->seePageIs('/home')
			// ->visit('/inputnoijazah')
			// ->seePageIs('/inputnoijazah')
		 //    ->post('inputnoijazah/inputNoIjazah/141414141414', ['_token' => csrf_token(), 
		 //    	'NIM' 			=> '141414141414', 
		 //    	'NAMA' 			=> 'Budi',
		 //    	'JENIS_KELAMIN' => '1',
		 //    	'UNIT' 			=> 'S1 Sistem Informasi',
		 //    	'TGL_LULUS' 	=> '2016-11-04',
		 //    	'NO_IJAZAH' 	=> 'NoIjazah',
		 //    	'IPK' 			=> '3.44',
		 //    	'SKS' 			=> '36',
		 //    	'ELPT' 			=> '567',
			// 	])
   //          ->seeJsonEquals([
   //              'success' 	=> true,
   //              'data' 		=> [ 
   //               			"NIM" 			=> "141414141414", 
   //               			"NAMA" 			=> "Budi", 
   //               			"JENIS_KELAMIN" => "Laki-laki", 
   //               			"UNIT" 			=> "S1 Sistem Informasi",
   //               			"TGL_LULUS" 	=> "04 Nov 2016", 
   //               			"NO_IJAZAH" 	=> "NoIjazah", 
   //               			"IPK" 			=> "3.44", 
   //               			"SKP" 			=> 100, 
   //               			"SKS" 			=> "36",
   //               			"ELPT" 			=> "567", 
   //               			],
   //           	])
   //          ;

   //  }

   //  public function testInputNoIjazahFailed()
   //  {
   //      $this->visit('/')
			// ->type('Akademik1', 'username')
			// ->type('Akademik1', 'password')
			// ->press('Log In')
			// ->seePageIs('/home')
			// ->visit('/inputnoijazah')
			// ->seePageIs('/inputnoijazah')
		 //    ->post('inputnoijazah/inputNoIjazah/141414141414', ['_token' => csrf_token(), 
		 //    	'NIM' 			=> '141414141414', 
		 //    	'NAMA' 			=> 'Budi',
		 //    	'JENIS_KELAMIN' => '1',
		 //    	'UNIT' 			=> 'S1 Sistem Informasi',
		 //    	'TGL_LULUS' 	=> '2016-11-04',
		 //    	'NO_IJAZAH' 	=> '',
		 //    	'IPK' 			=> '3.44',
		 //    	'SKS' 			=> '36',
		 //    	'ELPT' 			=> '567',
			// 	])
   //          ->see('No Ijazah is required.')
   //          ;

   //  }

   //  public function testInputNoIjazahFailedBackup()
   //  {
   //      $this->visit('/')
			// ->type('Akademik1', 'username')
			// ->type('Akademik1', 'password')
			// ->press('Log In')
			// ->seePageIs('/home')
			// ->visit('/inputnoijazah')
			// ->seePageIs('/inputnoijazah')

		 //    ->post('inputnoijazah/inputNoIjazah/141414141415', ['_token' => csrf_token(), 
		 //    	'NIM' => '14141414141511', 
		 //    	'NAMA' => 'Adam',
		 //    	'JENIS_KELAMIN' => '1',
		 //    	'UNIT' => 'S1 Sistem Informasi',
		 //    	'TGL_LULUS' => '2016-11-04',
		 //    	'NO_IJAZAH' => 'S1SistemInformasi',
		 //    	'IPK' => '3.44',
		 //    	'SKS' => '',
		 //    	'ELPT' => '567',
			// 	])
   //           // ->seeJsonEquals([
   //           //     // 'success' => false,
   //           //     'data' => ["ELPT" => "567", 
   //           //     			"IPK" => "3.44", 
   //           //     			"JENIS_KELAMIN" => "Laki-laki", 
   //           //     			"NAMA" => "Nama", 
   //           //     			"NIM" => "14141414141511", 
   //           //     			"NO_IJAZAH" => "S1SistemInformasi", 
   //           //     			"SKP" => " ", 
   //           //     			"SKS" => "36", 
   //           //     			"TGL_LULUS" => "04 Nov 2016", 
   //           //     			"UNIT" => "S1 Sistem Informasi"],
   //           //     			"success" => false,
   //           //    'errors' => ["SKS" => ["SKS is required."]], "success" => false,
   //           // ])
   //           ->see('SKS is required.')
   //           ;

   //  }

    public function testDataPeminjamanBuku()
    {
        $this->visit('/')
			->type('RuangBaca1', 'username')
			->type('RuangBaca1', 'password')
			->press('Log In')
			->seePageIs('/home')
			->click('pinjambuku')
			->seePageIs('/pinjambuku')
            ->see('Pinjam Buku');

    }


   //  public function testApprovePendaftaranSuccess32323()
   //  {
   //      // $this->assertTrue(true);
   //      $this->visit('/')
			// ->type('Sisfor01', 'username')
			// ->type('Sisfor01', 'password')
			// ->press('Log In')
			// ->seePageIs('/home')
			// ->visit('/approve')
			// ->seePageIs('/approve')
			// ->visit('/detail_mhs/141414141415')
			// ->seePageIs('/detail_mhs/141414141415')
			// // ->press('Cancel')
			// // // ->press('open-modal')
			// // ->get('/approve/edit/141414141414')
			// // ->post('/approvePendaftaran/141414141415')
			// // // ->press('approve2')
			// //  // ->post('/approve/approvePendaftaran/141414141414')
            
   // //          ->seeJson(['sfsfsf'=>'dfsfsf'])


			// // ->see('Cancel Pendaftaran')
			// ->click('ApproveButton')
			// // ->click('open-cancel')
			// ->see('Approve pendaftaran berhasil');
   //  }

}
