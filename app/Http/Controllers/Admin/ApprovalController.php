<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalController extends Controller
{

    public function index()
    {
        $users = User::whereNull('approved_at')->get();
        return view("admin.approval")->with("users",$users);
    }

    public function update($id)
    {
        $user = User::find($id);
        $user->approved_at = Carbon::now();
        $user->save();
        $message = $user->email." approved";
        return back()->with("message",$message);
    }

}
