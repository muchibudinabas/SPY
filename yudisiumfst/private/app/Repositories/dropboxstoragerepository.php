<?php namespace App\Repositories;

use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;
use Dropbox\Client;

class DropboxStorageRepository{

    protected $client;
    protected $adapter;
    public function __construct()
    {
        // $this->client = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_', 'yudisiumfst', null);
        // $this->client = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_', 'wisudafst', null);
        $this->client = new Client('cYgAJk_eLxAAAAAAAAAAKeqDN9KAU9fNixTGopVHwV9q6dPPFUIOkc_aL4vWdu8m', 'wisudafst', null);
        $this->adapter = new DropboxAdapter($this->client);
    }
    public function getConnection()
    {
        return new Filesystem($this->adapter);
    }

    public function getFile($file)
    {
        $this->$client = new Client('cYgAJk_eLxAAAAAAAAAAEw7NzQBPE8uyQClqptr6vyaejYXpeiRRklkj8XNYpBT_', 'yudisiumfst', null);
        $this->filesystem = new Filesystem(new Dropbox($client, '/path'));

        try{
            $file = $this->filesystem->read($file);
        }catch (\Dropbox\Exception $e){
            return Response::json("{'message' => 'File not found'}", 404);
        }

        $response = Response::make($file, 200);

        return $response;

    }
}
