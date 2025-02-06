<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


class FilmController extends Controller
{
    public function index()
    {
        return view('films.index'); // Passer les données à la vue
    }

    public function show($id)
{
    return view('films.show', ['filmId' => $id]);
}   

}

