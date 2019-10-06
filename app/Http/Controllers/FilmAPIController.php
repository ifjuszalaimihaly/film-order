<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilmAPIController extends Controller
{
    public function omdbapiRequest(Request $request)
    {
        $jsonFromApi = file_get_contents("http://www.omdbapi.com/?t=Interstellar&apikey=1e5f14ff");
        return response()->json();
    }
}
