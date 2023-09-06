<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
}
