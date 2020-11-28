<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class NcoreDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ncore:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ncore download';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->login();
    }


    private function login()
    {

        $uri = "https://ncore.cc/login.php";
        $client = new Client();
        try {
            $result = $client->post($uri, [
               // 'form_params' =>[
                'set_lang' => 'hu',
                    'submitted' => 1,
                    'nev' => "",
                    'pass' => "",
                    'submit' => 'Belépés!'
            //]
            ,
                    //'allow_redirects' => false
            ]);
            dd($result->getBody()->getContents());
        } catch (\Exception $exception){
            dd($exception->getMessage());
        }
        //$client = new Client();
        //$r=$client->get("http://faimei.skk.nyme.hu/");
        //dd($r->getBody()->getContents());
    }
}
