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
    public function index()
    {
        if (!Session::has('type') && !Session::has('message')) {
            Session::flash('type', 'info');
            Session::flash('message', 'Quản lý trạm');
        }
        return view('stations.index', ['stations' => Station::paginate(3), 'station_types' => StationType::all()]);
    }
    public function create()
    {
        return view('stations.create', ['data' => StationType::all()]);
    }
    public function store(StationRequest $request)
    {
        Station::create($request->validated());
        return redirect()->route('stations.index')->with([
            'type' => 'success',
            'message' => 'Thêm trạm mới thành công'
        ]);
    }
    public function show(Station $station)
    {
        return view('stations.show', compact('station'));
    }
    public function edit(Station $station)
    {
        return view('stations.edit', ['data' => StationType::all(), 'station' => $station]);
    }
    public function update(StationUpdate $request, Station $station)
    {
        $station->update($request->validated());
        return redirect()->route('stations.show', compact('station'))->with([
            'type' => 'success',
            'message' => 'Sửa trạm thành công'
        ]);
    }
    public function destroy(Station $station)
    {
        $exists = DB::table('ProcessContentSimple')->where('FK_Id_Station', $station->Id_Station)->exists();
        if ($exists) {
            return redirect()->route('stations.index')->with([
                'message' => 'Không thể xóa trạm này.',
                'type' => 'warning',
            ]);
        } else {
            $station->delete();

            return redirect()->route('stations.index')->with([
                'message' => 'Xóa trạm thành công',
                'type' => 'success',
            ]);
        }
    }
    public function showStationTypeById(Request $request)
    {
        $datas = DB::table('Station')->select('Id_Station', 'Name_Station', 'Ip_Address')->join('StationType', 'Id_StationType', '=', 'FK_Id_StationType')->where('FK_Id_StationType', '=', $request->id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $datas,
        ]);
    }
    public function getImgByStationType(Request $request)
    {
        $Id_StationType = $request->id;
        $stationType = StationType::find($Id_StationType);

        return response()->json($stationType);
    }
}
