<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;

use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        $orderBy = $request->input('orderBy', 'ASC');
        $state = $request->input('state', 'Tất cả');
        $paymentMethod = $request->input('paymentMethod', 'Tất cả');
        $customerPhone = $request->input('customerPhone', '');
        $address = $request->input('address', '');

        $query = Order::orderBy('NgayDat', $orderBy);

        if ($state !== 'Tất cả') {
            $query->where('TrangThaiDonHang', $state);
        }

        if ($paymentMethod !== 'Tất cả') {
            $query->where('HinhThucThanhToan', $paymentMethod);
        }

        if (!empty($customerPhone)) {
            $query->where('RecipientPhone', 'like', '%' . $customerPhone . '%');
        }

        if (!empty($address)) {
            $query->where('DiaChiGiaoHang', 'like', '%' . $address . '%');
        }

        $orders = $query->get();

        return view('admin.order.index', compact('orders', 'orderBy', 'state', 'paymentMethod', 'customerPhone', 'address'));
    }







    public function edit(Request $request)
    {
        $orders = Order::where("MaDonHang", $request->id)->first();
        if (!isset($orders)) {
            abort(404);
        }
        $customer = Customer::all();

        return view(
            'admin.order.edit',
            [
                'order' => $orders,
                'customer' => $customer,
                'id' => $orders->MaDonHang,
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
