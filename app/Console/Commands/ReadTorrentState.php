<?php

namespace App\Console\Commands;

use App\Film;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SplFileObject;

class ReadTorrentState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read:torrent-state';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        sleep(5);
        $file = new SplFileObject(__DIR__."/torrent-status.txt");

        if (!$file->eof()) {
            // Echo one line from the file.
            $this->info($file->fgets());
        }
        // Loop until we reach the end of the file.
        while (!$file->eof()) {
            // Echo one line from the file.
            $myArray = explode(',', $file->fgets());
            array_shift($myArray);
            //var_dump($myArray);
            if(count($myArray)>=9){
                $done = trim(substr($myArray[1],0,strlen($myArray[1]) - 1));
                if(is_numeric($myArray[4])){
                    $eta = $myArray[4].$myArray[5];
                    $status = $myArray[9];
                    $nameArray = array_slice($myArray, 10);
                    $name = trim(join(" ",$nameArray));
                } else {
                    $eta = $myArray[4];
                    $status = $myArray[8];
                    $nameArray = array_slice($myArray, 9);
                    $name = trim(join(" ",$nameArray));
                }
                $this->info("done ".$done);
                $this->info($eta);
                $this->info($status);
                $this->info($name);
                $film = Film::where("torrent_name",$name)->first();
                $this->info("film");
                $film->download_rate = $done;
                $film->save();
            }
        }

        // Unset the file to call __destruct(), closing the file handle.
        $file = null;
        $this->info("Hey, watch this !");
    }
}
