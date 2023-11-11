<?php

namespace App\Http\Controllers;

use App\Models\DonNhapHang;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        $ncc = NhaCungCap::get();
        $data = DonNhapHang::paginate(5);

        return view('index', compact('data', 'ncc'));
    }
}
