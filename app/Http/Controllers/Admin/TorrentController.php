<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;

class TorrentController extends Controller
{
    public function download($id, Request $request)
    {
        $request->torrent_file->storeAs('torrent_files', $request->torrent_file->getClientOriginalName());
    }
}
