<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;

use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('admin.order.index', compact('orders'));
    }

    public function edit(Request $request)
    {
        $orders = Order::where("MaDonHang", $request->id)->first();
        if (!isset($orders)) {
            abort(404);
        }
        $customer = Customer::all();

        return view('admin.order.edit', [
            'order' => $orders, 
            'customer' => $customer,
            'id'=> $orders->MaDonHang,
            ]
        );
    }

    public function update(Request $request)
    {

        $orders = Order::findOrFail($request->id);
        $orders->TrangThaiDonHang = $request->TrangThaiDonHang;

        $orders->save();

        return redirect()->route('order.index')->with('success', 'Order updated successfully.');
    }

}
