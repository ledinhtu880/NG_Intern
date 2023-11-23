<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\ProductionStationLine;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (!Session::has("type") && !Session::has("message")) {
            Session::flash('type', 'info');
            Session::flash('message', 'Trang chủ');
        }
        return view('index', ['productionStationLines' => ProductionStationLine::all(), 'stations' => Station::all()]);
    }
}
