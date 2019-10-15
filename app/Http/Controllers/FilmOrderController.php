<?php

namespace App\Http\Controllers;

use App\Film;
use App\Notifications\FilmOrderAdminNotification;
use App\Notifications\FilmOrderNotification;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class FilmOrderController extends Controller
{

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                "original_title" => "required|unique:films",
                "translated_title" => "required|unique:films",
                "imdb" => "required|unique:films",
            ]
        );
        if ($validator->fails()){
            error_log($validator->errors());
            return response()->json(['error'=>$validator->errors()->all()],400);
        }
        $film = new Film();
        $film->original_title = $request->original_title;
        $film->translated_title = $request->translated_title;
        $film->imdb = $request->imdb;
        $film->release_year = $request->release_year;
        $film->rating = $request->rating;
        $film->status_id = 1;
        $user = Auth::user();
        $order = new Order();
        $order->owner = 1;
        $order->user_id = $user->id;
        $film->save();
        $film->orders()->save($order);
        $user->notify(new FilmOrderNotification($film));
        User::where('admin',1)->first()->notify(new FilmOrderAdminNotification($user,$film));
        return response()->json("success");
    }
}
