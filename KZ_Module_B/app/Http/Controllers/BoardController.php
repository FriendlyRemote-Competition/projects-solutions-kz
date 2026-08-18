<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {
        $stations = Station::orderBy('code')->get();

        return view('board.index', compact('stations'));
    }

    public function show(Station $station)
    {
        return view('board.show', compact('station'));
    }
}
