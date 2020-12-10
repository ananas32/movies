<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $movie = new Movie;

        $bestMovies = $movie->makeQueryList('is_usa');

        return view('home', compact('bestMovies'));
    }
}


