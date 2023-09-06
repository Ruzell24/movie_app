<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FavoriteMovie;

class MovieController extends Controller
{
    public function getMovies(Request $request)
    {
        $client = new \GuzzleHttp\Client([
            'verify' => public_path('cacert.pem'),
        ]);
        

        $page = $request->query('page', 1);
       
        $movie = $client->request('GET', 'https://api.themoviedb.org/3/discover/movie', [
            'query' => [
                'page' => $page
            ],
            'headers' => [
              'Authorization' => 'Bearer ' . env('MOVIE_READ_APP_KEY'),
              'accept' => 'application/json',
            ],
          ]);

          $body = $movie->getBody();

          return response()->json([
            "movie" => json_decode($body),
        ], 200);
    }

    public function addToFavoriteMovie(Request $request){
        $request->validate([
            'movie_name' => 'string|required',
            'movie_id' => 'int|required' ,
        ]);


        $id = auth()->user()->id;
    

        $newBookmark = new FavoriteMovie([
            "user_id" => $id,
            "movie_name" => $request->movie_name,
            "movie_id" => $request->movie_id
        ]);

        $newBookmark->save();

        return response([
            "movie" => $newBookmark
        ],201);
    }

    public function getMovieBookmark(Request $request){

        $movieList = auth()->user()->bookmarkMovieList()->get();

        return response([
            "movie" => $movieList
        ],200);
    }
}
