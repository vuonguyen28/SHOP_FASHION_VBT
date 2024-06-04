<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

use App\Models\Feedback;
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
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function FeedbackToOrderDetail(Request $request){

        $userID = session('LoggedUser');
        if(!$userID){
            return redirect()->route('login.login')->with('error','vui lòng đăng nhập để feedback');
        }
        Feedback::create([
            'MaKH'=>session('LoggedUser'),
            'MaChiTietDH'=> $request->MaChiTietDonHang,
            'NoiDung'=>$request->NoiDung,
            'ThoiGianfeedback'=>date('d-m-y H:i:s'),
            'DanhGia'=>$request->DanhGia,
            
        ]);
        return redirect()->back()->with('success','đã feedback thành công đơn hàng');
    }
}
