<?php

namespace App\Console\Commands;

use App\Film;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileObject;

class DownloadTorrent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:torrent';

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
        sleep(30);
        $path = storage_path("app/torrentfiles");
        $torrent_files = File::allFiles($path);
        foreach ($torrent_files as $torrent_file) {
            try {
                $film = Film::where("torrent_file", $torrent_file->getFilename())->firstOrFail();
                if (is_null($film->torrent_name)) {
                    $command = "transmission-remote -n 'transmission:transmission' -a " . $torrent_file->getRealPath();
                    exec($command);
                    $torrent_names = $this->getRunningTorrentNames();
                    foreach ($torrent_names as $torrent_name) {
                        var_dump($torrent_file->getFilename());
                        var_dump($torrent_name);
                        if (Str::contains($torrent_file->getFilename(), $torrent_name)) {
                            var_dump("contains");
                            $film->torrent_name = $torrent_name;
                            $film->save();
                        }
                    }
                }
            } catch (ModelNotFoundException $exception){

            }
        }
    }

    private function getRunningTorrentNames() :array
    {
        exec("transmission-remote -n 'transmission:transmission' -l | tr -s '[:blank:]' ',' > ".__DIR__."/torrent-status-new-torrent.txt");

        sleep(1);
        $file = new SplFileObject(__DIR__ . "/torrent-status-new-torrent.txt");

        // Loop until we reach the end of the file.
        $torrentNames = [];
        while (!$file->eof()) {
            // Echo one line from the file.
            $myArray = explode(',', $file->fgets());
            array_shift($myArray);
            //var_dump($myArray);
            if (count($myArray) >= 9) {
                $done = trim(substr($myArray[1], 0, strlen($myArray[1]) - 1));
                if (is_numeric($myArray[4])) {
                    $nameArray = array_slice($myArray, 10);
                    $name = trim(join(" ", $nameArray));
                    $torrentNames[] = $name;
                } else {
                    $nameArray = array_slice($myArray, 9);
                    $name = trim(join(" ", $nameArray));
                    $torrentNames[] = $name;
                }
            }
        }
        return array_slice($torrentNames,1);
    }
}
