<?php

namespace App\Http\Controllers;

use App\Models\OrderLocal;
use App\Models\ContentPack;
use App\Models\ContentSimple;
use App\Models\DetailContentSimpleOfPack;
use App\Models\DetailContentSimpleOrderLocal;
use App\Models\DetailProductionStationLine;
use App\Models\ProcessContentSimple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class InfoOrderLocalController extends Controller
{

    public function index()
    {
        return view('tracking.orderlocals.index');
    }
    public function getInfoOrderLocal(Request $request)
    {
        $Type_orderlocal = $request->input('Type_orderlocal');
        $orderlocals = DB::table('OrderLocal')->where('MakeOrPackOrExpedition', $Type_orderlocal)->get();
        $percents = [];
        $infor = [
            'orderlocals' => $orderlocals,
            'percents' => $percents
        ];
        return response()->json($infor);
    }
    public function detailSimples(string $id)
    {
        $contentSimples = DB::table('DetailContentSimpleOrderLocal as DL')->join('ContentSimple as C', 'DL.FK_Id_ContentSimple', '=', 'C.Id_SimpleContent')->join('RawMaterial as R', 'R.Id_RawMaterial', '=', 'C.FK_Id_RawMaterial')->join('ContainerType as CT', 'CT.Id_ContainerType', '=', 'C.FK_Id_ContainerType')->where('DL.FK_Id_OrderLocal', $id)->get();
        $station = $this->getStationPercentBySimpleContent($contentSimples);
        return view(
            'tracking.orderlocals.ShowDetailSimples',
            [
                'data' => $contentSimples,
                'station_start' => $station['station_start'],
                'station_end' => $station['station_end'],
                'station_currents' => $station['station_currents']
            ]
        );
    }
    public function detailPacks(string $id)
    {
        $contentPacks = DB::table('DetailContentSimpleOrderLocal as DL')
            ->join('ContentSimple as C', 'DL.FK_Id_ContentSimple', '=', 'C.Id_SimpleContent')
            ->join('DetailContentSimpleOfPack as DP', 'DP.FK_Id_SimpleContent', '=', 'C.Id_SimpleContent')
            ->join('ContentPack as CP', 'CP.Id_PackContent', '=', 'DP.FK_Id_PackContent')
            ->where('DL.FK_Id_OrderLocal', $id)
            ->select('CP.*')
            ->distinct()
            ->get();
        $percents = [];
        foreach ($contentPacks as $contentPack) {
            $Id_SimpleContents = DetailContentSimpleOfPack::where('FK_Id_PackContent', $contentPack->Id_PackContent)->pluck('FK_Id_SimpleContent')->toArray();
            $simpleContents = [];
            foreach ($Id_SimpleContents as $Id_SimpleContent) {
                $simpleContents[] = ContentSimple::find($Id_SimpleContent);
            }
            $percents[] = $this->percentSimpleOrPack($simpleContents);
        }
        return view(
            'tracking.orderlocals.ShowDetailPacks',
            compact('contentPacks', 'percents')
        );
    }
    private function getStationPercentBySimpleContent($contentSimples)
    {
        $stations = [];
        $FK_Id_Orderlocals = [];
        $station_start = 0;
        $station_end = 0;
        try {
            // Lấy ra trạm đầu và trạm cuối cùng của 1 thùng và số lượng trạm
            $FK_Id_Orderlocals = DetailContentSimpleOrderLocal::join('ProcessContentSimple as pcs', 'pcs.FK_Id_ContentSimple', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
                ->where('pcs.FK_Id_ContentSimple', $contentSimples[0]->Id_SimpleContent)
                ->groupBy('DetailContentSimpleOrderLocal.FK_Id_OrderLocal')
                ->pluck('DetailContentSimpleOrderLocal.FK_Id_OrderLocal')->toArray();
            $stations = DetailProductionStationLine::join('DispatcherOrder as do', 'do.FK_Id_ProdStationLine', 'DetailProductionStationLine.FK_Id_ProdStationLine')
                ->whereIn('do.FK_Id_OrderLocal', $FK_Id_Orderlocals)
                ->pluck('FK_Id_Station')->toArray();
            $lenStations = count($stations);

            if (count($stations) > 0) {
                $station_start = $stations[0];
                $station_end = $stations[count($stations) - 1];
            }
            $station_cur = [];
            foreach ($contentSimples as $contentSimple) {
                $Id_SimpleContent = $contentSimple->Id_SimpleContent;
                $station_cur[] = ProcessContentSimple::where('FK_Id_ContentSimple', $Id_SimpleContent)
                    ->select('FK_Id_Station', 'FK_Id_State')->get()->toArray();
            }

            for ($i = 0; $i < count($station_cur); $i++) {
                usort($station_cur[$i], function ($a, $b) {
                    return $a['FK_Id_Station'] - $b['FK_Id_Station'];
                });
            }

            $station_currents = [];
            foreach ($station_cur as $station) {
                if (count($station) > 0 && $station[count($station) - 1]['FK_Id_State'] == 0) {
                    $station_currents[] = $station[count($station) - 1]['FK_Id_Station'] - 1;;
                } else if (count($station) > 0 && $station[count($station) - 1]['FK_Id_State'] == 2) {
                    $station_currents[] = $station[count($station) - 1]['FK_Id_Station'];
                }
            }

            // Tính phần trăm hoàn thành
            foreach ($station_currents as &$station_current) {
                $count = 0;
                foreach ($stations as $station) {
                    if ($station_current >= $station) {
                        $count++;
                    }
                }
                $station_current = round($count / $lenStations * 100, 2);
            }
            return [
                'station_start' => $station_start,
                'station_end' => $station_end,
                'station_currents' => $station_currents
            ];
        } catch (Exception $e) {
            return [
                'station_start' => $station_start,
                'station_end' => $station_end,
                'station_currents' => -1
            ];
        }
    }
    private function percentSimpleOrPack($simpleContents)
    {
        $station = $this->getStationPercentBySimpleContent($simpleContents);
        $percent = 0;
        if ($station['station_currents'] != -1) {
            $count_station_currents = count($station['station_currents']);
            if ($count_station_currents > 0) {
                $summ = 0;
                foreach ($station['station_currents'] as $station_current) {
                    $summ += $station_current;
                }
                $percent = round($summ / ($count_station_currents * 100), 2);
            }
        }
        return $percent;
    }
    public function detailSimpleOfPack(Request $request)
    {
        $Id_PackContent = $request->id_PackContent;
        $Id_SimpleContents = DetailContentSimpleOfPack::where('FK_Id_PackContent', $Id_PackContent)->pluck('FK_Id_SimpleContent')->toArray();
        // $contentSimples_json = [];
        $simpleContents = [];

        foreach ($Id_SimpleContents as $Id_SimpleContent) {
            $simpleContents[] = ContentSimple::find($Id_SimpleContent);
        }

        $station = $this->getStationPercentBySimpleContent($simpleContents);

        $htmls = '';
        for ($i = 0; $i < count($simpleContents); $i++) {
            $htmls .= '
                <tr>
                    <td class="align-middle">' . $simpleContents[$i]->Id_SimpleContent . '</td>
                    <td class="align-middle">' . $simpleContents[$i]->material->Name_RawMaterial . '</td>
                    <td class="align-middle">' . $simpleContents[$i]->material->Unit . '</td>
                    <td class="align-middle">' . $simpleContents[$i]->type->Name_ContainerType . '</td>
                    <td class="align-middle">' . number_format($simpleContents[$i]->Price_Container, 0, ',', '.') . ' VNĐ' . '</td>
                    <td class="align-middle">
                        <div class="d-flex justify-content-center">
                            <div class="progress w-50 position-relative" role="progressbar" aria-valuenow="' . $station['station_currents'][$i] . '"
                                aria-valuemin="0" aria-valuemax="100" style="height: 20px">
                                <div class="progress-bar bg-primary-color" style="width: ' . $station['station_currents'][$i] . '%">
                                </div>
                                <span class="progress-text fw-bold fs-6';
            if ($station['station_currents'][$i] < 50) {
                $htmls .= ' text-primary-color';
            } else {
                $htmls .= ' text-white';
            }
            $htmls .= '">' . $station['station_currents'][$i] . '%
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
            ';
        }

        return $htmls;
    }
    public function showDetailsSimple(string $id)
    {
        $simple = ContentSimple::find($id);
        $FK_Id_ProdStationLine = DB::table('DispatcherOrder as do')
            ->join('OrderLocal as ol', 'do.FK_Id_OrderLocal', '=', 'ol.Id_OrderLocal')
            ->join('DetailContentSimpleOrderLocal as dsol', 'ol.Id_OrderLocal', '=', 'dsol.FK_Id_OrderLocal')
            ->where('dsol.FK_Id_ContentSimple', '=', $id)
            ->value('do.FK_Id_ProdStationLine');

        $data = DB::table('Station as s')
            ->select('st.PathImage', 's.Id_Station', 's.Name_Station', 'st.Name_StationType')
            ->join('StationType as st', 's.FK_Id_StationType', '=', 'st.Id_StationType')
            ->join('DetailProductionStationLine as dpsl', 's.Id_Station', '=', 'dpsl.FK_Id_Station')
            ->join('DispatcherOrder as do', 'do.FK_Id_ProdStationLine', '=', 'dpsl.FK_Id_ProdStationLine')
            ->where('do.FK_Id_ProdStationLine', '=', $FK_Id_ProdStationLine)
            ->groupBy('st.PathImage', 's.Id_Station', 's.Name_Station', 'st.Name_StationType')
            ->orderBy('s.Id_Station')
            ->get();

        $result = DB::table('ProcessContentSimple')
            ->select('FK_Id_Station', 'Data_Fin', DB::raw("CONCAT(
                    FLOOR(DATEDIFF(second, Data_Start, Data_Fin) / 3600), N' giờ, ',
                    FLOOR((DATEDIFF(second, Data_Start, Data_Fin) % 3600) / 60), N' phút, ',
                    (DATEDIFF(second, Data_Start, Data_Fin) % 60), N' giây') as elapsedTime"))
            ->where('FK_Id_ContentSimple', '=', $id)
            ->orderBy('FK_Id_Station')
            ->get();

        $countComplete = 0;

        foreach ($data as $each) {
            $found = false;
            foreach ($result as $processSimple) {
                if ($each->Id_Station == $processSimple->FK_Id_Station) {
                    if ($processSimple->Data_Fin == null) {
                        $each->status = 'Chưa hoàn thành';
                        $each->elapsedTime = 'Chưa hoàn thành';
                    } else {
                        $each->elapsedTime = $processSimple->elapsedTime;
                        $each->status = 'Hoàn thành';
                        $countComplete++;
                    }

                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $each->status = 'Chưa hoàn thành';
                $each->elapsedTime = 'Chưa hoàn thành';
            }
        }

        if (count($data) == 0) {
            $simple->progress = 'Thùng hàng chưa được khởi động';
        } else {
            $percent = ($countComplete / count($data)) * 100;
            $simple->progress = (int) $percent;
            $totalTime = DB::table('ProcessContentSimple')
                ->select(DB::raw("CONCAT(
            FLOOR(SUM(DATEDIFF(second, Data_Start, Data_Fin)) / 3600), N' giờ, ',
            FLOOR((SUM(DATEDIFF(second, Data_Start, Data_Fin)) % 3600) / 60), N' phút, ',
            (SUM(DATEDIFF(second, Data_Start, Data_Fin)) % 60), N' giây'
        ) as elapsedTime"))
                ->where('FK_Id_ContentSimple', 2)
                ->havingRaw('SUM(DATEDIFF(second, Data_Start, Data_Fin)) IS NOT NULL')
                ->first();

            $simple->elapsedTime = $totalTime->elapsedTime;
        }

        $simple->progress == 100 ? $simple->status = 'Hoàn thành' : $simple->status = 'Chưa hoàn thành';
        return view('tracking.orderlocals.detailSimples', compact('simple', 'data'));
    }
}