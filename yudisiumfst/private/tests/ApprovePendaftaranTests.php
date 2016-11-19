<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApprovePendaftaranTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
   //  public function testApprovePendaftaranSuccess()
   //  {
   //      // $this->assertTrue(true);
   //      $this->visit('/')
			// ->type('SistemInformasi', 'username')
			// ->type('SistemInformasi2016', 'password')
			// ->press('Log In')
			// ->seePageIs('/home')
			// ->visit('/approve')
			// // ->press('open-modal')
			// ->get('/approve/edit/141414141414')
			// ->post('/approve/approvePendaftaran/141414141414')
			// // ->press('approve2')
			//  // ->post('/approve/approvePendaftaran/141414141414')
            
   //          ->seeJson(['sfsfsf'=>'dfsfsf'])


			// // ->see('Apakah anda yakin akan mengapprove data')


			// ;
   //  }

     public function testApprovePendaftaranSuccess()
    {
        // $this->assertTrue(true);
        $this->visit('/')
			->type('Sisfor01', 'username')
			->type('Sisfor01', 'password')
			->press('Log In')
			->seePageIs('/home')
			->visit('/approve')
			->seePageIs('/approve')
			->visit('/detail_mhs/141414141415')
			->seePageIs('/detail_mhs/141414141415')

			// // ->press('open-modal')
			// ->get('/approve/edit/141414141414')
			// ->post('/approve/approvePendaftaran/141414141414')
			// // ->press('approve2')
			//  // ->post('/approve/approvePendaftaran/141414141414')
            
   //          ->seeJson(['sfsfsf'=>'dfsfsf'])


			->see('Apakah anda yakin akan mengapprove data')


			;
    }
}
