<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContentPack;
use App\Models\ContentSimple;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order; // Import the Order model
use App\Models\DetailContentSimpleOrderLocal;
use App\Models\DetailProductionStationLine;
use App\Models\ProcessContentSimple;
use App\Models\DetailContentSimpleOfPack;
use Exception;


class InforCustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('tracking.customers.InforCustomerController', compact('customers'));
    }
    public function getInforCustomer(Request $request)
    {
        $Id_Customer = $request->Id_Customer;
        $customer = Customer::find($Id_Customer);
        $transport = $customer->types->Name_ModeTransport;
        $customerType = $customer->customerType->Name;
        $orders = Order::where('FK_Id_Customer', $Id_Customer)->get();
        $percents = [];
        foreach ($orders as $order) {
            $order->Date_Delivery = date('d-m-Y h:m:s', strtotime($order->Date_Delivery));
            $order->Date_Order = date('d-m-Y h:m:s', strtotime($order->Date_Order));
            if ($order->SimpleOrPack == 0) {
                // Tính trạng thái sản phẩm đối với thùng hàng
                $contentSimple = ContentSimple::where('FK_Id_Order', $order->Id_Order)->get();
                $percents[] = $this->percentSimpleOrPack($contentSimple);
            } else {
                // Tính trạng thái sản phẩm đối với gói hàng
                $contentPacks = ContentPack::where('FK_Id_Order', $order->Id_Order)->get();
                if (count($contentPacks) > 0) {
                    foreach ($contentPacks as $contentPack) {
                        $Id_ContentSimples = DetailContentSimpleOfPack::where('FK_Id_ContentPack', $contentPack->Id_ContentPack)->pluck('FK_Id_ContentSimple')->toArray();
                        $ContentSimples = [];
                        foreach ($Id_ContentSimples as $Id_ContentSimple) {
                            $ContentSimples[] = ContentSimple::find($Id_ContentSimple);
                        }
                        $percents[] = $this->percentSimpleOrPack($ContentSimples);
                    }
                } else {
                    $percents[] = 0;
                }
            }
        }
        $infor = [
            'customer' => $customer,
            'transport' => $transport,
            'customerType' => $customerType,
            'orders' => $orders,
            'percents' => $percents
        ];
        return response()->json($infor);
    }
    private function getStationPercentByContentSimple($contentSimples)
    {
        $stations = [];
        $FK_Id_Orderlocals = [];
        $station_start = 0;
        $station_end = 0;
        try {
            // Lấy ra trạm đầu và trạm cuối cùng của 1 thùng và số lượng trạm
            $FK_Id_Orderlocals = DetailContentSimpleOrderLocal::join('ProcessContentSimple as pcs', 'pcs.FK_Id_ContentSimple', 'DetailContentSimpleOrderLocal.FK_Id_ContentSimple')
                ->where('pcs.FK_Id_ContentSimple', $contentSimples[0]->Id_ContentSimple)
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
                $Id_ContentSimple = $contentSimple->Id_ContentSimple;
                $station_cur[] = ProcessContentSimple::where('FK_Id_ContentSimple', $Id_ContentSimple)
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
    public function detailSimples(Request $request)
    {
        $Id_Order = $request->Id_Order;
        $order = Order::find($Id_Order);
        $contentSimples = ContentSimple::where('FK_Id_Order', $Id_Order)->get();
        $station = $this->getStationPercentByContentSimple($contentSimples);
        return view(
            'tracking.customers.ShowDetailSimples',
            [
                'data' => $contentSimples,
                'station_start' => $station['station_start'],
                'station_end' => $station['station_end'],
                'station_currents' => $station['station_currents'],
                'order' => $order
            ]
        );
    }
    private function percentSimpleOrPack($ContentSimples)
    {
        $station = $this->getStationPercentByContentSimple($ContentSimples);
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
    public function detailPacks(Request $request)
    {
        $Id_Order = $request->Id_Order;
        $order = Order::find($Id_Order);
        $contentPacks = ContentPack::where('FK_Id_Order', $Id_Order)->get();
        $percents = [];
        foreach ($contentPacks as $contentPack) {
            $Id_ContentSimples = DetailContentSimpleOfPack::where('FK_Id_ContentPack', $contentPack->Id_ContentPack)->pluck('FK_Id_ContentSimple')->toArray();
            $ContentSimples = [];
            foreach ($Id_ContentSimples as $Id_ContentSimple) {
                $ContentSimples[] = ContentSimple::find($Id_ContentSimple);
            }
            $percents[] = $this->percentSimpleOrPack($ContentSimples);
        }
        return view(
            'tracking.customers.ShowDetailPacks',
            compact('order', 'contentPacks'),
            [
                'percents' => $percents
            ]
        );
    }
    public function detailSimpleOfPack(Request $request)
    {
        $Id_ContentPack = $request->id_ContentPack;
        $Id_ContentSimples = DetailContentSimpleOfPack::where('FK_Id_ContentPack', $Id_ContentPack)->pluck('FK_Id_ContentSimple')->toArray();
        // $contentSimples_json = [];
        $ContentSimples = [];

        foreach ($Id_ContentSimples as $Id_ContentSimple) {
            $ContentSimples[] = ContentSimple::find($Id_ContentSimple);
        }

        $station = $this->getStationPercentByContentSimple($ContentSimples);

        $htmls = '';
        for ($i = 0; $i < count($ContentSimples); $i++) {
            $htmls .= '
                <tr>
                    <td class="align-middle">' . $ContentSimples[$i]->Id_ContentSimple . '</td>
                    <td class="align-middle">' . $ContentSimples[$i]->material->Name_RawMaterial . '</td>
                    <td class="align-middle">' . $ContentSimples[$i]->material->Unit . '</td>
                    <td class="align-middle">' . $ContentSimples[$i]->type->Name_ContainerType . '</td>
                    <td class="align-middle">' . number_format($ContentSimples[$i]->Price_Container, ($ContentSimples[$i]->Price_Container == (int)$ContentSimples[$i]->Price_Container) ? 0 : 2, ',', '.') . ' VNĐ' . '</td>
                    <td class="align-middle">
                        <div class="d-flex justify-content-center">
                            <div class="progress w-50 position-relative" role="progressbar" aria-valuenow="' . $station['station_currents'][$i] . '"
                                aria-valuemin="0" aria-valuemax="100" style="height: 20px">
                                <div class="progress-bar bg-primary" style="width: ' . $station['station_currents'][$i] . '%">
                                </div>
                                <span class="progress-text fw-bold fs-6';
            if ($station['station_currents'][$i] < 50) {
                $htmls .= ' text-primary';
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
}
