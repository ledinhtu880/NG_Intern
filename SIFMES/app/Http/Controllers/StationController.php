<?php

namespace App\Http\Controllers;

use App\Http\Requests\Station\StationRequest;
use App\Http\Requests\Station\StationUpdate;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\StationType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (!Session::has('type') && !Session::has('message')) {
            Session::flash('type', 'info');
            Session::flash('message', 'Quản lý trạm');
        }
        return view('stations.index', ['stations' => Station::paginate(3), 'station_types' => StationType::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('stations.create', ['data' => StationType::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StationRequest $request)
    {
        //
        $station = Station::create($request->validated());
        return redirect()->route('stations.index')->with([
            'type' => 'success',
            'message' => 'Thêm trạm mới thành công'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Station $station)
    {
        //
        return view('stations.show', compact('station'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Station $station)
    {
        //
        return view('stations.edit', ['data' => StationType::all(), 'station' => $station]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StationUpdate $request, Station $station)
    {
        //
        $station->update($request->validated());
        return redirect()->route('stations.show', compact('station'))->with([
            'type' => 'success',
            'message' => 'Sửa trạm thành công'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Station $station)
    {
        //
        // return Station::find($station);
        $station->delete();
        return redirect()->route('stations.index')->with('type', 'success')->with('message', 'Xóa trạm thành công');
    }

    public function showStationTypeById(Request $request)
    {
        $datas = DB::table('Station')->select('Id_Station', 'Name_Station', 'Ip_Address')->join('StationType', 'Id_StationType', '=', 'FK_Id_StationType')->where('FK_Id_StationType', '=', $request->id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $datas,
        ]);
    }
}
