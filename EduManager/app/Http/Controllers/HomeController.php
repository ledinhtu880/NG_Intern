<?php

namespace App\Http\Controllers;

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
        return view('index');
    }
}
