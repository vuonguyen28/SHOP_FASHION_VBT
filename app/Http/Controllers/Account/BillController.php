<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\ProductDetails;
use App\Models\Color;
use App\Models\Size;
use App\Models\Voucher;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\VoucherToCustomer;
use Illuminate\Support\Facades\Session;

class BillController extends Controller
{
    public function UpdateAdressAndPhone(Request $request)
    {
        $orderDetail = Order::where('MaDonHang', $request->MaDonHang)->first();
        if (!$orderDetail) {
            return redirect()->back()->with('error', 'cập nhật đơn hàng thất bại');
        } else {
            $orderDetail->RecipientPhone =  $request->phone;
            $orderDetail->DiaChiGiaoHang =  $request->Address;
            $orderDetail->save();
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
        }
    }


    public function CancelOrder(Request $request)
    {
        $orderDetail = Order::where('MaDonHang', $request->MaDonHang)->first();
        if (!$orderDetail) {
            return redirect()->back()->with('error', 'hủy đơn hàng thất bại');
        } else {
            $orderDetail->TrangThaiDonHang =  "ĐÃ HỦY";
            $orderDetail->save();
            return redirect()->back()->with('success', 'hủy đơn thành công thành công');
        }
    }


    //xem đơn hàng đang giao
    public function CheckYourOrder(Request $request)
    {

        $IdUser = session('LoggedUser');
        if (!$IdUser) {
            return route('login.login', [
                'success' => 'vui lòng đăng nhập để để xem trang thái đơn hàng',
            ]);
        }
        $orders = Order::where('MaKhachHang', session('LoggedUser'))
            ->where('TrangThaiDonHang', 'ĐANG GIAO')
            ->get();
        $orderDetail = OrderDetails::where('MaDonHang', $request->MaDonHang)->get();
        return view('account.Order.ShowBillCustomer', [
            'orders' => $orders,
            'orderDetail' => $orderDetail,
            'check' => '0',
        ]);
    }

    //xem chi tiết đơn hàng đang giao
    public function CheckYourOrder_Detail_Bill(Request $request)
    {
        $IdUser = session('LoggedUser');
        if (!$IdUser) {
            return route('login.login', [
                'success' => 'vui lòng đăng nhập để để xem trang thái đơn hàng',
            ]);
        }
        $orders = Order::where('MaKhachHang', session('LoggedUser'))->where('MaDonHang', $request->MaDonHang)->get();
        $orderDetail = OrderDetails::where('MaDonHang', $request->MaDonHang)->get();
        return view('account.Order.ShowBillCustomer', [
            'orders' => $orders,
            'orderDetail' => $orderDetail,
            'check' => '1',
        ]);
    }




    public function ShowOrderedBill(Request $request)
    {
        $IdUser = session('LoggedUser');
        if (!$IdUser) {
            return route('login.login', [
                'success' => 'vui lòng đăng nhập để để xem trang thái đơn hàng',
            ]);
        }
        $orders = Order::where('MaKhachHang', session('LoggedUser'))
            ->where('TrangThaiDonHang', 'Đã đặt hàng')
            ->get();
        $orderDetail = OrderDetails::where('MaDonHang', $request->MaDonHang)->get();
        
        return view('account.Order.ordered_bill', [
            'orders' => $orders,
            'orderDetail' => $orderDetail,
            'check' => '0',
        ]);
    }


    public function ShowCancelledBill(Request $request)
    {

        $IdUser = session('LoggedUser');
        if (!$IdUser) {
            return route('login.login', [
                'success' => 'vui lòng đăng nhập để để xem trang thái đơn hàng',
            ]);
        }
        $orders = Order::where('MaKhachHang', session('LoggedUser'))
            ->where('TrangThaiDonHang', 'ĐÃ HỦY')
            ->get();
        $orderDetail = OrderDetails::where('MaDonHang', $request->MaDonHang)->get();
       
        return view('account.Order.cancelled_bill', [
            'orders' => $orders,
            'orderDetail' => $orderDetail,
            'check' => '0',
           
        ]);
    
    }

    public function ShowCancelledBill_Detail_Bill(Request $request)
    {
        $IdUser = session('LoggedUser');
        if (!$IdUser) {
            return route('login.login', [
                'success' => 'vui lòng đăng nhập để để xem trang thái đơn hàng',
            ]);
        }
        $orders = Order::where('MaKhachHang', session('LoggedUser'))->where('MaDonHang', $request->MaDonHang)->get();
        $orderDetail = OrderDetails::where('MaDonHang', $request->MaDonHang)->get();
        return view('account.Order.cancelled_bill', [
            'orders' => $orders,
            'orderDetail' => $orderDetail,
            'check' => '1',
        ]);
    }


    public function ShowOrdered_Detail_Bill(Request $request)
    {
        $IdUser = session('LoggedUser');
        if (!$IdUser) {
            return route('login.login', [
                'success' => 'vui lòng đăng nhập để để xem trang thái đơn hàng',
            ]);
        }
        $orders = Order::where('MaKhachHang', session('LoggedUser'))->where('MaDonHang', $request->MaDonHang)->get();
        $orderDetail = OrderDetails::where('MaDonHang', $request->MaDonHang)->get();
        return view('account.Order.ordered_bill', [
            'orders' => $orders,
            'orderDetail' => $orderDetail,
            'check' => '1',
        ]);
    }


    //

    public function ShowDeliveredBill(Request $request)
    {


        $IdUser = session('LoggedUser');
        if (!$IdUser) {
            return route('login.login', [
                'success' => 'vui lòng đăng nhập để để xem trang thái đơn hàng',
            ]);
        }
        $orders = Order::where('MaKhachHang', session('LoggedUser'))
            ->where('TrangThaiDonHang', 'ĐÃ NHẬN')
            ->get();
        $orderDetail = OrderDetails::where('MaDonHang', $request->MaDonHang)->get();
        return view('account.Order.delivered_bill', [
            'orders' => $orders,
            'orderDetail' => $orderDetail,
            'check' => '0',
        ]);
    }

    public function ShowDeliveredBill_Detail_Bill(Request $request)
    {
        $IdUser = session('LoggedUser');
        if (!$IdUser) {
            return route('login.login', [
                'success' => 'vui lòng đăng nhập để để xem trang thái đơn hàng',
            ]);
        }
        $orders = Order::where('MaKhachHang', session('LoggedUser'))->where('MaDonHang', $request->MaDonHang)->get();
        $orderDetail = OrderDetails::where('MaDonHang', $request->MaDonHang)->get();
        return view('account.Order.delivered_bill', [
            'orders' => $orders,
            'orderDetail' => $orderDetail,
            'check' => '1',
        ]);
    }
}
