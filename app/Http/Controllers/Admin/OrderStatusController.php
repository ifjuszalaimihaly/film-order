<?php

namespace App\Http\Controllers\Admin;

use App\Film;
use App\Order;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\OrderStatusChangedNotification;

class OrderStatusController extends Controller
{
    public function index()
    {
        $orders = Order::where("owner","=",1)->with(["film","user","film.status"])->paginate(5);
        $statuses = Status::all();
        return view("admin.order-status",["orders"=>$orders,"statuses"=>$statuses]);
    }

    public function update($id, Request $request)
    {
        $film = Film::find($id);
        $film->status_id = $request->status_id;
        $status = $film->status->name;
        $film->save();
        $orders = $film->orders()->with("user")->get();
        $message = "The new status of the film (".$film->original_title.", ".$film->translated_tile.") is ".$status;
        foreach ($orders as $order){
            $user = $order->user()->first();
            $user->notify(new OrderStatusChangedNotification($film));
        }
        return back()->with("message",$message);
    }
}
