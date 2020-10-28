<?php

namespace App\Http\Controllers\Admin;

use App\Film;
use App\Notifications\OrderStatusChangedNotification;
use App\Notifications\UserApprovedNotification;
use App\Order;
use App\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TorrentFileUploadController extends Controller
{

    public function index()
    {
        $orders = Order::where("owner","=",1)->with(["film"])->paginate(5);
        return view("admin.torrent-file-upload",["orders"=>$orders]);
    }

    public function upload($id, Request $request)
    {
        $film = Film::find($id);
        $film->save();
        $request->torrentfile->storeAs('torrentfiles', $request->torrentfile->getClientOriginalName());
        $message = "The torrentfile of the film (".$film->original_title.", ".$film->translated_tile.") is added";
        return back()->with("message",$message);
    }

}
