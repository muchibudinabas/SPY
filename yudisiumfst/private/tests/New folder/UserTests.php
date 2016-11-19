<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCasescsc
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function testExample()
    {

    	        // $this->visit('/daftar_yudisium')
        //  ->type('Taylor', 'nim')
        //  ->press('Daftar')
        //  ->seePageIs('/thanks');



        
        // $this->assertTrue(true);
        // $response = $this->call('GET','test');
        // $this->assertTrue(strpos($response->getContent(), 'tes') !==false);

        // $this->visit('/')
        //  ->click('Log In')
        //  ->seePageIs('/login');

        // $this->visit('/')
        //  ->see('Sistem Pendaftaran Yudisium | Fakultas Sains Teknologi Universitas Airlangga');

    	// $this->visit('tracking')
     //     ->type(null, 'nim')
     //     ->press('Tracking')
     //     ->see('tracking');

    	// $this->seeInDatabase('alumni', ['NIM' => '081211631057']);


         // ->seePageIs('/dashboard');

    }

    // protected function see($text, $element = 'body') {
    //     $crowler = $this->client->getCrowles();
    //     $found = $crowler->filter("{$element}:contains('{$text}')");

    //     $this->assertGreaterThan(0, count($found), "Expected to see {$text} within the view");
    // }
}
