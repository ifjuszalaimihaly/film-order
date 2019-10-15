<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Validator;

class FilmAPIController extends Controller
{
    //TODO add abstract superclass, or just remove code duplications

    public function omdbAPIRequest(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                "title" => "required_without:imdb_id",
                "imdb_id" => "required_without:title",
            ]
        );
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()->all()],400);
        }
        $uri = "http://www.omdbapi.com/";
        if ($request->title) {
            $uri .= "?t=" . $request->title;
        }
        if ($request->imdb_id) {
            $uri .= "?i=" . $request->imdb_id;
        }
        $uri .= "&apikey=" . env("OMDB_API_KEY");
        try {
            $client = new Client();
            $result = $client->get($uri);
            $result = json_decode($result->getBody()->getContents(), true);
            if (array_key_exists("Error",$result)) {
                return response()->json(["error" => "Film not found"],404);
            }
            return response()->json([
                "title" => $result["Title"],
                "year" => $result["Year"],
                "img" => $result["Poster"],
                "imdb_id" => $result["imdbID"],
                "rating" => $result["imdbRating"]

            ]);
        }  catch (ClientException $exception) {
            return response()->json(["error" => "Unauthorized"],401);
        } catch (ConnectException $exception) {
            return response()->json(["error" => "API server not available"],503);
        }
    }

    public function theMovieDbAPIRequest(Request $request)
    {

        $validator= Validator::make($request->all(),
            [
                "imdb_id" => "required",
            ]
        );
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()->all()],400);
        }
        $uri = "https://api.themoviedb.org/3/find/";
        $uri.=$request->imdb_id;
        $uri.= "?external_source=imdb_id&api_key=".env("THE_MOVIE_DB_API_KEY")."&language=hu";
        try {
            $client = new Client();
            $result = $client->get($uri);
            $result = json_decode($result->getBody()->getContents(),true);
            if($result["movie_results"] == []){
                return response()->json(["error" => "Film not found"],404);
            }
            $movie_results = $result["movie_results"][0];
            return response()->json([
                "title"=>$movie_results["title"],
                "overview"=>$movie_results["overview"]
            ]);
        } catch (ClientException $exception) {
            return response()->json(["error" => "Unauthorized"],401);
        } catch (ConnectException $exception) {
            return response()->json(["error" => "API server not available"],503);
        }
    }
}
