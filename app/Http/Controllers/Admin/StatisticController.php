<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetails;
use Carbon\Carbon;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalOrders = OrderDetails::getTotalOrdersCount();
        $totalQuantity = OrderDetails::getTotalQuantity();
        $totalRevenue = OrderDetails::getTotalRevenue();

        return view('admin.statistic.index', compact('totalOrders', 'totalQuantity', 'totalRevenue'));
    }

    public function filter_by_date(Request $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $orders = Order::whereBetween('NgayDat', [$from_date, $to_date])
            ->orderBy('NgayDat', 'ASC')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->NgayDat)->format('Y-m-d'); 
            });

        $chart_data = [];
        $total_revenue = 0;
        $total_quantity = 0;
        $total_orders = 0;

        foreach ($orders as $date => $dailyOrders) {
            $dailyRevenue = $dailyOrders->sum('TongGia');
            $dailyQuantity = $dailyOrders->sum(function ($order) {
                return $order->orderDetails->sum('SoLuong');
            });
            $dailyOrderCount = $dailyOrders->count();

            $total_revenue += $dailyRevenue;
            $total_quantity += $dailyQuantity;
            $total_orders += $dailyOrderCount;

            $chart_data[] = [
                'period' => $date,
                'order' => $dailyOrderCount,
                'sales' => $dailyRevenue,
                'quantity' => $dailyQuantity
            ];
        }

        return response()->json([
            'chart_data' => $chart_data,
            'total_revenue' => $total_revenue,
            'total_quantity' => $total_quantity,
            'total_orders' => $total_orders
        ]);
    }

    public function days_order()
    {
        $sub30days = Carbon::now()->subDays(30)->toDateString();
        $now = Carbon::now()->toDateString();

        $orders = Order::whereBetween('NgayDat', [$sub30days, $now])
            ->orderBy('NgayDat', 'ASC')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->NgayDat)->format('Y-m-d'); 
            });

        $chart_data = [];
        $total_revenue = 0;
        $total_quantity = 0;
        $total_orders = 0;

        foreach ($orders as $date => $dailyOrders) {
            $dailyRevenue = $dailyOrders->sum('TongGia');
            $dailyQuantity = $dailyOrders->sum(function ($order) {
                return $order->orderDetails->sum('SoLuong');
            });
            $dailyOrderCount = $dailyOrders->count();

            $total_revenue += $dailyRevenue;
            $total_quantity += $dailyQuantity;
            $total_orders += $dailyOrderCount;

            $chart_data[] = [
                'period' => $date,
                'order' => $dailyOrderCount,
                'sales' => $dailyRevenue,
                'quantity' => $dailyQuantity
            ];
        }

        return response()->json([
            'chart_data' => $chart_data,
            'total_revenue' => $total_revenue,
            'total_quantity' => $total_quantity,
            'total_orders' => $total_orders
        ]);
    }

    public function dashboard_filter(Request $request)
    {
        $dashboard_value = $request->input('dashboard_value');
        $orders = collect();

        switch ($dashboard_value) {
            case '7ngay':
                $sub7days = Carbon::now()->subDays(7)->toDateString();
                $orders = Order::whereBetween('NgayDat', [$sub7days, Carbon::now()])->orderBy('NgayDat', 'ASC')->get();
                break;
            case 'thangtruoc':
                $dauthang = Carbon::now()->subMonth()->startOfMonth()->toDateString();
                $cuoithang = Carbon::now()->subMonth()->endOfMonth()->toDateString();
                $orders = Order::whereBetween('NgayDat', [$dauthang, $cuoithang])->orderBy('NgayDat', 'ASC')->get();
                break;
            case 'thangnay':
                $dauthangnay = Carbon::now()->startOfMonth()->toDateString();
                $orders = Order::whereBetween('NgayDat', [$dauthangnay, Carbon::now()])->orderBy('NgayDat', 'ASC')->get();
                break;
            case '365ngayqua':
                $sub365days = Carbon::now()->subDays(365)->toDateString();
                $orders = Order::whereBetween('NgayDat', [$sub365days, Carbon::now()])->orderBy('NgayDat', 'ASC')->get();
                break;
            default:
                return response()->json(['error' => 'Giá trị lọc không hợp lệ.']);
        }

        $orders = $orders->groupBy(function ($date) {
            return Carbon::parse($date->NgayDat)->format('Y-m-d'); 
        });

        $chart_data = [];
        $total_revenue = 0;
        $total_quantity = 0;
        $total_orders = 0;

        foreach ($orders as $date => $dailyOrders) {
            $dailyRevenue = $dailyOrders->sum('TongGia');
            $dailyQuantity = $dailyOrders->sum(function ($order) {
                return $order->orderDetails->sum('SoLuong');
            });
            $dailyOrderCount = $dailyOrders->count();

            $total_revenue += $dailyRevenue;
            $total_quantity += $dailyQuantity;
            $total_orders += $dailyOrderCount;

            $chart_data[] = [
                'period' => $date,
                'order' => $dailyOrderCount,
                'sales' => $dailyRevenue,
                'quantity' => $dailyQuantity
            ];
        }

        return response()->json([
            'chart_data' => $chart_data,
            'total_revenue' => $total_revenue,
            'total_quantity' => $total_quantity,
            'total_orders' => $total_orders
        ]);
    }
}
