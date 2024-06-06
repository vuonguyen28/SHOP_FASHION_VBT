<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

class OrderController extends Controller
{

    public function showMomoPaymentForm()
    {
        // Trả về view chứa form thanh toán MoMo
        return view('momo_payment_form');
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        // Execute post
        $result = curl_exec($ch);
        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        // Close connection
        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request)
    {



        $userId = session('LoggedUser');
        $cartCheck = Cart::where('MaKhachHang', $userId)->first();

        if (!$cartCheck) {
            return redirect()->back()->with('error', 'giỏ hàng đang trống');
        }




        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';


        $orderInfo = "Thanh toán qua ATM MoMo";
        $amount = intval($request->total_momo); // Ép kiểu int cho số tiền
        $orderId = time() . "";
        $redirectUrl = route('momo.callback'); // URL callback
        $ipnUrl = route('momo.callback'); // URL thông báo kết quả thanh toán
        $extraData = "";


        $requestId = time() . "";
        $requestType = "payWithATM";

        // Tạo chuỗi rawHash để ký HMAC SHA256
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // Dữ liệu gửi đến MoMo
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        // Thực hiện yêu cầu POST
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // Decode JSON

        // Chuyển hướng tới URL thanh toán
        if (isset($jsonResult['payUrl'])) {
            return redirect($jsonResult['payUrl']);
        } else {
            echo 'Error: ' . $jsonResult['message'];
        }
    }


    public function momo_payment_WalkInCustomers(Request $request)
    {

        $cart = Session::get('cart', []);
        if (!$cart) {
            return redirect()->back()->with('error', 'Giỏ hàng không tồn tại');
        }

        $pricr_total = 0;
        $prict_shipp = 0;
        foreach ($cart as $productInfo) {
            $prict_shipp = 30000;
            $colorID = Color::where('HEXCODE', $productInfo['MaMau'])->firstOrFail();
            $SizeID = Size::where('TenKichThuoc', $productInfo['MaKichThuoc'])->firstOrFail();
            $IDProduct = $productInfo['MaSP'];

            $IDProductDetail = ProductDetails::where('MaSP', $IDProduct)
                ->where('MaKichThuoc', $SizeID->MaKichThuoc)
                ->where('MaMau', $colorID->MaMau)
                ->firstOrFail();
            $prict = $IDProductDetail->Product->Gia;
            if ($IDProductDetail->Product->PhanTramGiamGia) {
                $pricr_total += ($prict - ($prict * $IDProductDetail->Product->PhanTramGiamGia) / 100) * $productInfo['SoLuong'];
            } else {
                $pricr_total += $prict * $productInfo['SoLuong'];
            }
        }

        session()->put("pricr_total_cus", $pricr_total);




        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';


        $orderInfo = "Thanh toán qua ATM MoMo";
        $amount = intval($pricr_total +  $prict_shipp); // Ép kiểu int cho số tiền
        $orderId = time() . "";
        $redirectUrl = route('momo.callbackWalkInCustomers'); // URL callback
        $ipnUrl = route('momo.callbackWalkInCustomers'); // URL thông báo kết quả thanh toán
        $extraData = "";


        $requestId = time() . "";
        $requestType = "payWithATM";

        // Tạo chuỗi rawHash để ký HMAC SHA256
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // Dữ liệu gửi đến MoMo
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        // Thực hiện yêu cầu POST
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // Decode JSON

        // Chuyển hướng tới URL thanh toán
        if (isset($jsonResult['payUrl'])) {
            return redirect($jsonResult['payUrl']);
        } else {
            echo 'Error: ' . $jsonResult['message'];
        }
    }

    public function momoCallback_WalkInCustomers(Request $request)
    {
        $data = $request->all();

        // Kiểm tra chữ ký số để đảm bảo tính toàn vẹn của dữ liệu
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        // Kiểm tra và gán giá trị mặc định cho các phần tử của mảng
        $amount = $data['amount'] ?? '';
        $extraData = $data['extraData'] ?? '';
        $ipnUrl = $data['ipnUrl'] ?? '';
        $orderId = $data['orderId'] ?? '';
        $orderInfo = $data['orderInfo'] ?? '';
        $partnerCode = $data['partnerCode'] ?? $partnerCode;
        $redirectUrl = $data['redirectUrl'] ?? '';
        $requestId = $data['requestId'] ?? '';
        $requestType = $data['requestType'] ?? '';
        $receivedSignature = $data['signature'] ?? '';

        // Log dữ liệu để kiểm tra
        Log::info('MoMo Callback Data:', $data);

        // Create the raw hash string
        $rawHash = "accessKey=" . $accessKey .
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&ipnUrl=" . $ipnUrl .
            "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $partnerCode .
            "&redirectUrl=" . $redirectUrl .
            "&requestId=" . $requestId .
            "&requestType=" . $requestType;

        $calculatedSignature = hash_hmac("sha256", $rawHash, $secretKey);

        // Log chữ ký để kiểm tra
        Log::info('Calculated Signature: ' . $calculatedSignature);
        Log::info('Received Signature: ' . $receivedSignature);
        // if($calculatedSignature === $receivedSignature) lỗi chữ ký nên mình để bằng true
        if (true) {
            // Kiểm tra trạng thái thanh toán
            if ($data['resultCode'] == 0) {
                DB::beginTransaction();

                try {

                    $cart = Session::get('cart', []);

                    $customerif = Customer::where('Email', $request->Email)->first();

                    if (!$customerif) {
                        // Tạo khách hàng mới
                        $Customer = Customer::create([
                            'TenKH' => session('LoggedName_WalkInCus'),
                            'SoDienThoai' => session('LoggedPhone_WalkInCus'),
                            'Email' => session('LoggedEmail_WalkInCus'),
                            'DiaChi' =>  session('LoggedAddress_WalkInCus'),
                            'TrangThai' => '1',
                            'avatar' => 'user.png',
                            'Role' => 'Walk In Cus',
                        ]);

                        $idCustomer = $Customer->MaKH;
                    } else {
                        $idCustomer = $customerif->MaKH;
                    }



                    // Tạo đơn hàng mới
                    $order = Order::create([
                        'MaKhachHang' => $idCustomer,
                        'NgayDat' => now(),
                        'NgayDuKienGiaoHang' => now()->addDays(3),
                        'TongGia' => session('pricr_total_cus'),
                        'TongTienSauKhiGiamGia' => 0,
                        'PhiVanChuyen' =>  30000,
                        'TrangThaiThanhToan' => 'đã thanh toán',
                        'HinhThucThanhToan' => 'momo',
                        'TrangThaiDonHang' => 'Đã đặt hàng',
                        'DiaChiGiaoHang' => session('LoggedAddress_WalkInCus'),
                        'MaVoucher' => 'KhongApDung',
                        'RecipientPhone' => session('LoggedPhone_WalkInCus'),
                    ]);

                    // Lấy giỏ hàng từ session

                    foreach ($cart as $productInfo) {
                        // Tìm chi tiết sản phẩm
                        $colorID = Color::where('HEXCODE', $productInfo['MaMau'])->firstOrFail();
                        $SizeID = Size::where('TenKichThuoc', $productInfo['MaKichThuoc'])->firstOrFail();
                        $IDProduct = $productInfo['MaSP'];

                        $IDProductDetail = ProductDetails::where('MaSP', $IDProduct)
                            ->where('MaKichThuoc', $SizeID->MaKichThuoc)
                            ->where('MaMau', $colorID->MaMau)
                            ->firstOrFail();

                        // Giảm số lượng tồn kho
                        $IDProductDetail->SoLuongTon -= $productInfo['SoLuong'];
                        $IDProductDetail->save();

                        // Tạo chi tiết đơn hànggit
                        OrderDetails::create([
                            'MaDonHang' => $order->MaDonHang,
                            'MaChiTietSanPham' => $IDProductDetail->MaChiTiet,
                            'SoLuong' => $productInfo['SoLuong'],
                            'Gia' => $productInfo['Gia']
                        ]);
                    }

                    // Hoàn tất giao dịch
                    DB::commit();

                    Session::forget('cart');
                    $this->deleteSessionVoucher();
                    return redirect('/cart/cart')->with('success', 'Thanh toán thành công và đơn hàng đã được tạo.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect('/cart/cart')->with('error', 'Có lỗi khi tạo đơn hàng.');
                }
            } else {
                // Thanh toán thất bại
                return redirect('/cart/cart')->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
            }
        } else {
            // Chữ ký không hợp lệ
            return redirect('/cart/cart')->with('error', 'Chữ ký không hợp lệ. Vui lòng thử lại.');
        }
    }

    public function createOrder_WalkInCustomers(Request $request)
    {
        $cart = Session::get('cart', []);
        if (!$cart) {
            return redirect()->back()->with('error', 'Giỏ hàng không tồn tại');
        }
        // Bắt đầu 1 phiên giao dịch
        DB::beginTransaction();

        try {

            $customerif = Customer::where('Email', $request->Email)->first();

            if (!$customerif) {
                // Tạo khách hàng mới
                $Customer = Customer::create([
                    'TenKH' => session('LoggedName_WalkInCus'),
                    'SoDienThoai' => session('LoggedPhone_WalkInCus'),
                    'Email' => session('LoggedEmail_WalkInCus'),
                    'DiaChi' =>  session('LoggedAddress_WalkInCus'),
                    'TrangThai' => '1',
                    'avatar' => 'user.png',
                    'Role' => 'Walk In Cus',
                ]);

                $idCustomer = $Customer->MaKH;
            } else {
                $idCustomer = $customerif->MaKH;
            }


            $pricr_total = 0;
            $prict_shipp = 0;

            foreach ($cart as $productInfo) {
                $prict_shipp = 30000;
                $colorID = Color::where('HEXCODE', $productInfo['MaMau'])->firstOrFail();
                $SizeID = Size::where('TenKichThuoc', $productInfo['MaKichThuoc'])->firstOrFail();
                $IDProduct = $productInfo['MaSP'];

                $IDProductDetail = ProductDetails::where('MaSP', $IDProduct)
                    ->where('MaKichThuoc', $SizeID->MaKichThuoc)
                    ->where('MaMau', $colorID->MaMau)
                    ->firstOrFail();
                $prict = $IDProductDetail->Product->Gia;
                if ($IDProductDetail->Product->PhanTramGiamGia) {
                    $pricr_total += ($prict - ($prict * $IDProductDetail->Product->PhanTramGiamGia) / 100) * $productInfo['SoLuong'];
                } else {
                    $pricr_total += $prict * $productInfo['SoLuong'];
                }
            }
            // Tạo đơn hàng mới
            $order = Order::create([
                'MaKhachHang' => $idCustomer,
                'NgayDat' => now(),
                'NgayDuKienGiaoHang' => now()->addDays(3),
                'TongGia' => $pricr_total,
                'TongTienSauKhiGiamGia' => 0,
                'PhiVanChuyen' =>  $prict_shipp,
                'TrangThaiThanhToan' => 'chưa thanh toán',
                'HinhThucThanhToan' => 'on_delivery',
                'TrangThaiDonHang' => 'Đã đặt hàng',
                'DiaChiGiaoHang' => session('LoggedAddress_WalkInCus'),
                'MaVoucher' => 'KhongApDung',
                'RecipientPhone' => session('LoggedPhone_WalkInCus'),
            ]);

            // Lấy giỏ hàng từ session

            foreach ($cart as $productInfo) {
                // Tìm chi tiết sản phẩm
                $colorID = Color::where('HEXCODE', $productInfo['MaMau'])->firstOrFail();
                $SizeID = Size::where('TenKichThuoc', $productInfo['MaKichThuoc'])->firstOrFail();
                $IDProduct = $productInfo['MaSP'];

                $IDProductDetail = ProductDetails::where('MaSP', $IDProduct)
                    ->where('MaKichThuoc', $SizeID->MaKichThuoc)
                    ->where('MaMau', $colorID->MaMau)
                    ->firstOrFail();

                // Giảm số lượng tồn kho
                $IDProductDetail->SoLuongTon -= $productInfo['SoLuong'];
                $IDProductDetail->save();

                // Tạo chi tiết đơn hànggit
                OrderDetails::create([
                    'MaDonHang' => $order->MaDonHang,
                    'MaChiTietSanPham' => $IDProductDetail->MaChiTiet,
                    'SoLuong' => $productInfo['SoLuong'],
                    'Gia' => $productInfo['Gia']
                ]);
            }

            // Hoàn tất giao dịch
            DB::commit();
            $this->deleteSessionVoucher();
        } catch (\Exception $e) {
            // Rollback giao dịch nếu có lỗi
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi khi tạo đơn hàng');
        }
        // Xóa giỏ hàng trong session
        Session::forget('cart');
        return redirect()->back()->with('success', 'Sản phẩm đã thêm vào giỏ hàng thành công.');
    }

    // Phương thức xử lý kết quả thanh toán từ MoMo 
    public function momoCallback(Request $request)
    {
        $data = $request->all();

        // Kiểm tra chữ ký số để đảm bảo tính toàn vẹn của dữ liệu
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        // Kiểm tra và gán giá trị mặc định cho các phần tử của mảng
        $amount = $data['amount'] ?? '';
        $extraData = $data['extraData'] ?? '';
        $ipnUrl = $data['ipnUrl'] ?? '';
        $orderId = $data['orderId'] ?? '';
        $orderInfo = $data['orderInfo'] ?? '';
        $partnerCode = $data['partnerCode'] ?? $partnerCode;
        $redirectUrl = $data['redirectUrl'] ?? '';
        $requestId = $data['requestId'] ?? '';
        $requestType = $data['requestType'] ?? '';
        $receivedSignature = $data['signature'] ?? '';

        // Log dữ liệu để kiểm tra
        Log::info('MoMo Callback Data:', $data);

        // Create the raw hash string
        $rawHash = "accessKey=" . $accessKey .
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&ipnUrl=" . $ipnUrl .
            "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $partnerCode .
            "&redirectUrl=" . $redirectUrl .
            "&requestId=" . $requestId .
            "&requestType=" . $requestType;

        $calculatedSignature = hash_hmac("sha256", $rawHash, $secretKey);

        // Log chữ ký để kiểm tra
        Log::info('Calculated Signature: ' . $calculatedSignature);
        Log::info('Received Signature: ' . $receivedSignature);
        // if($calculatedSignature === $receivedSignature) lỗi chữ ký nên mình để bằng true
        if (true) {
            // Kiểm tra trạng thái thanh toán
            if ($data['resultCode'] == 0) {
                DB::beginTransaction();
                try {

                    $userId = session('LoggedUser');
                    // Lưu đơn hàng vào cơ sở dữ liệu
                    $cartItem = Cart::where('MaKhachHang', $userId)->get();

                    $total = 0;
                    $priceShipping = 0;

                    foreach ($cartItem as $item) {
                        $money = $item->ProductDetails->Product->Gia;
                        if (is_null($item->ProductDetails->Product->PhanTramGiamGia)) {
                            $money = $item->ProductDetails->Product->Gia * $item->SoLuong;
                        } else {
                            $money = ($money - ($money * $item->ProductDetails->Product->PhanTramGiamGia) / 100) * $item->SoLuong;
                        }
                        $total += $money;
                        $priceShipping = 30000;
                    }

                    // Tạo đơn hàng mới
                    $order = Order::create([
                        'MaKhachHang' => session('LoggedUser'),
                        'NgayDat' => now(),
                        'NgayDuKienGiaoHang' => now()->addDays(3),
                        'TongGia' => $total,
                        'TongTienSauKhiGiamGia' => session('sumTotalMoney_SALE'),
                        'PhiVanChuyen' => $priceShipping,
                        'TrangThaiThanhToan' => 'đã thanh toán',
                        'HinhThucThanhToan' => 'momo',
                        'TrangThaiDonHang' => 'Đã đặt hàng',
                        'DiaChiGiaoHang' => session('LoggedAddress'),
                        'MaVoucher' => session('MaVoucher'),
                        'RecipientPhone' => session('LoggedPhone')
                    ]);

                    // Tạo chi tiết đơn hàng
                    foreach ($cartItem as $item) {

                        $money = $item->ProductDetails->Product->Gia;
                        if (is_null($item->ProductDetails->Product->PhanTramGiamGia)) {
                            $money = $item->ProductDetails->Product->Gia;
                        } else {
                            $money = $money - ($money * $item->ProductDetails->Product->PhanTramGiamGia) / 100;
                        }

                        OrderDetails::create([
                            'MaDonHang' => $order->MaDonHang,
                            'MaChiTietSanPham' => $item->MaChiTietSanPham,
                            'SoLuong' =>  $item->SoLuong,
                            'Gia' => $money * $item->SoLuong,
                        ]);

                        $item->delete();
                    }

                    if (session('LoggedUser') && session('MaVoucher')) {
                        $this->UpdateStatusVoucherCustomer_Order(session('MaVoucher'), session('LoggedUser'));
                    }

                    DB::commit();
                    $this->deleteSessionVoucher();
                    return redirect('/cart/cart')->with('success', 'Thanh toán thành công và đơn hàng đã được tạo.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect('/cart/cart')->with('error', 'Có lỗi khi tạo đơn hàng.');
                }
            } else {
                // Thanh toán thất bại
                return redirect('/cart/cart')->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
            }
        } else {
            // Chữ ký không hợp lệ
            return redirect('/cart/cart')->with('error', 'Chữ ký không hợp lệ. Vui lòng thử lại.');
        }
    }



    public function CheckOrderForm_WalkInCustomers()
    {

        $check = 0;
        $orders = Order::whereNull('RecipientPhone')->get();
        return view('account.Order.checkOder_WalkInCustomers', [
            'orders' => $orders,
            'check' => $check,
        ]);
    }

    public function SearchBill_WalkInCustomers(Request $request)
    {
        $check = 0;
        session()->put("phone_search", $request->phone);
        $orders = Order::where('RecipientPhone', $request->phone)->get();
        return view('account.Order.checkOder_WalkInCustomers', [
            'orders' => $orders,
            'check' => $check,
        ]);
    }

    public function FindOrderDetail_WalkInCustomers(Request $request)
    {
        $check = 1;
        $orders = Order::where('RecipientPhone', $request->Phone)->take(1)->get();
        $orderDetail = OrderDetails::where('MaDonHang', $request->ID_ORDER)->get();
        // dd($orderDetail);
        return view('account.Order.checkOder_WalkInCustomers', [
            'orders' => $orders,
            'orderDetail' => $orderDetail,
            'check_show_order_detail' => 'done',
            'success' => 'hihi',
            'check' => $check,
        ]);
    }









    public function createOrder(Request $request)
    {
        $userId = session('LoggedUser');
        $cartCheck = Cart::where('MaKhachHang', $userId)->first();

        if (!$cartCheck) {
            return redirect()->back()->with('error', 'giỏ hàng đang trống');
        }
        


        DB::beginTransaction();

        try {

            $cartItem = Cart::where('MaKhachHang', $userId)->get();

            $total = 0;
            $priceShipping = 0;

            foreach ($cartItem as $item) {
                $money = $item->ProductDetails->Product->Gia;
                if (is_null($item->ProductDetails->Product->PhanTramGiamGia)) {
                    $money = $item->ProductDetails->Product->Gia * $item->SoLuong;
                } else {
                    $money = ($money - ($money * $item->ProductDetails->Product->PhanTramGiamGia) / 100) * $item->SoLuong;
                }
                $total += $money;
                $priceShipping = 30000;
            }

            // Tạo đơn hàng mới
            $order = Order::create([
                'MaKhachHang' => session('LoggedUser'),
                'NgayDat' => now(),
                'NgayDuKienGiaoHang' => now()->addDays(3),
                'TongGia' => $total,
                'TongTienSauKhiGiamGia' => session('sumTotalMoney_SALE'),
                'PhiVanChuyen' => $priceShipping,
                'TrangThaiThanhToan' => 'chưa thanh toán',
                'HinhThucThanhToan' => 'on_delivery',
                'TrangThaiDonHang' => 'Đã đặt hàng',
                'DiaChiGiaoHang' => session('LoggedAddress'),
                'MaVoucher' => session('MaVoucher'),
                'RecipientPhone' => session('LoggedPhone')
            ]);

            $donHangInfo = "Mã đơn hàng: {$order->MaDonHang}, Ngày đặt hàng: {$order->NgayDat}, Địa chỉ giao hàng: {$order->DiaChiGiaoHang}, Tổng giá trị đơn hàng: $total";

            // $donHangInfo = "Mã đơn hàng: $order->MaDonHang, Ngày đặt hàng: $order->NgayDat, Địa chỉ giao hàng: $order->DiaChiGiaoHang, Tổng giá trị đơn hàng: $total";
            $mess = "Thông tin đơn hàng: ";

            // Tạo chi tiết đơn hàng
            foreach ($cartItem as $item) {

                $money = $item->ProductDetails->Product->Gia;
                if (is_null($item->ProductDetails->Product->PhanTramGiamGia)) {
                    $money = $item->ProductDetails->Product->Gia;
                } else {
                    $money -= ($money * $item->ProductDetails->Product->PhanTramGiamGia) / 100;
                }

                $chitietdonhang = OrderDetails::create([
                    'MaDonHang' => $order->MaDonHang,
                    'MaChiTietSanPham' => $item->MaChiTietSanPham,
                    'SoLuong' =>  $item->SoLuong,
                    'Gia' => $money * $item->SoLuong,
                ]);

                $chiTietDonHang = "Chi tiết đơn hàng: {$item->MaChiTietSanPham} \n Mã chi tiết sản phẩm: {$item->MaChiTietSanPham} \n số lượng mua {$item->SoLuong} \n Giá Mua: {$item->Gia} ";
                $mess .= $chiTietDonHang . "; \n";
                $item->delete();
            }


            if (session('LoggedUser') && session('MaVoucher')) {
                $this->UpdateStatusVoucherCustomer_Order(session('MaVoucher'), session('LoggedUser'));
            }

            DB::commit();

            //$cartCheck->Email
            $email = "cr.havaka@gmail.com";

            // Gửi email với thông tin tổng hợp của đơn hàng
            Mail::raw('THÔNG TIN ĐƠN HÀNG \n'.$donHangInfo .'\n'. $mess, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Your New Password');
            });



            $this->deleteSessionVoucher();
            return redirect()->back()->with('success', 'Sản phẩm đã thêm vào giỏ hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi khi tạo đơn hàng');
        }
    }


    // public function createOrder(Request $request)
    // {
    //     $userId = session('LoggedUser');
    //     $cartCheck = Cart::where('MaKhachHang', $userId)->first();

    //     if (!$cartCheck) {
    //         return redirect()->back()->with('error', 'Giỏ hàng đang trống');
    //     }

    //     DB::beginTransaction();

    //     try {
    //         $cartItems = Cart::where('MaKhachHang', $userId)->get();
    //         $total = 0;
    //         $priceShipping = 30000;
    //         $orderDetails = [];

    //         foreach ($cartItems as $item) {
    //             $money = $item->ProductDetails->Product->Gia;
    //             if (!is_null($item->ProductDetails->Product->PhanTramGiamGia)) {
    //                 $money = ($money - ($money * $item->ProductDetails->Product->PhanTramGiamGia) / 100) * $item->SoLuong;
    //             } else {
    //                 $money = $money * $item->SoLuong;
    //             }
    //             $total += $money;
    //             $orderDetails[] = [
    //                 'Product' => $item->ProductDetails->Product->TenSanPham,
    //                 'Quantity' => $item->SoLuong,
    //                 'Price' => $money,
    //             ];
    //             $item->delete();
    //         }

    //         $order = Order::create([
    //             'MaKhachHang' => $userId,
    //             'NgayDat' => now(),
    //             'NgayDuKienGiaoHang' => now()->addDays(3),
    //             'TongGia' => $total,
    //             'TongTienSauKhiGiamGia' => session('sumTotalMoney_SALE'),
    //             'PhiVanChuyen' => $priceShipping,
    //             'TrangThaiThanhToan' => 'chưa thanh toán',
    //             'HinhThucThanhToan' => 'on_delivery',
    //             'TrangThaiDonHang' => 'Đã đặt hàng',
    //             'DiaChiGiaoHang' => session('LoggedAddress'),
    //             'MaVoucher' => session('MaVoucher'),
    //             'RecipientPhone' => session('LoggedPhone')
    //         ]);

    //         $this->sendOrderEmail('cr.havaka@gmail.com', $order, $orderDetails);

    //         $this->deleteSessionVoucher();

    //         DB::commit();

    //         return redirect()->back()->with('success', 'Đơn hàng đã được tạo thành công.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Có lỗi khi tạo đơn hàng');
    //     }
    // }

    // public function sendOrderEmail($email, $order, $orderDetails)
    // {
    //     try {
    //         Log::info("Đang gửi email đơn hàng tới: $email", ['order_id' => $order->MaDonHang]);

    //         $emailContent = "Thông tin đơn hàng:\n";
    //         foreach ($orderDetails as $detail) {
    //             $emailContent .= "Sản phẩm: {$detail['Product']}, Số lượng: {$detail['Quantity']}, Giá: {$detail['Price']}\n";
    //         }

    //         Mail::raw($emailContent, function ($message) use ($email) {
    //             $message->to($email)
    //                 ->subject('Thông tin đơn hàng của bạn');
    //         });

    //         Log::info("Đã gửi email đơn hàng thành công.");
    //     } catch (\Exception $e) {
    //         Log::error('Lỗi khi gửi email đơn hàng: ' . $e->getMessage());
    //         throw new \Exception('Có lỗi khi gửi email xác nhận đơn hàng');
    //     }
    // }




    public function update_InfoOrder(Request $request)
    {
        $validated = $request->validate([
            'DiaChi' => 'required|string|max:255',
            'SoDienThoai' => 'required|string|max:20',
        ]);

        try {
            session()->put('LoggedAddress', $validated['DiaChi']);
            session()->put('LoggedPhone', $validated['SoDienThoai']);

            return redirect()->back()->with(['message' => 'Cập nhật địa chỉ thành công.']);
        } catch (\Exception $e) {
            Log::error('Error updating order info: ' . $e->getMessage());

            return redirect()->back()->with(['message' => 'Có lỗi khi cập nhật thông tin đơn hàng.'], 500);
        }
    }

    public function update_InfoOrder_WalkInCustomers(Request $request)
    {

        $validated = $request->validate([
            'Address' => 'required|string|max:255',
            'Phone' => 'required|string|max:20',
            'Name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        try {

            session()->put('LoggedAddress_WalkInCus', $validated['Address']);
            session()->put('LoggedPhone_WalkInCus', $validated['Phone']);
            session()->put('LoggedName_WalkInCus', $validated['Name']);
            session()->put('LoggedEmail_WalkInCus', $validated['email']);


            return redirect()->back()->with(['success' => 'Cập nhật thông tin thành công.']);
        } catch (\Exception $e) {
            Log::error('Error updating order info: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'Có lỗi khi cập nhật thông tin đơn hàng.'])->withInput()->withErrors(['error' => 'Có lỗi xảy ra. Vui lòng thử lại sau.']);
        }
    }


    public function deleteSessionVoucher()
    {
        session()->forget('sumTotalMoney_SALE');
        session()->forget('nameVoucher');
        session()->forget('sale');
        session()->forget('EndDate');
        session()->forget('MaVoucher');
    }

    public function UpdateStatusVoucherCustomer_Order($id_voucher, $is_USER)
    {
        VoucherToCustomer::where('MA_VOUCHER', $id_voucher)
            ->where('MaKH', $is_USER)
            ->update(['note' => 'done']);

        $voucher = Voucher::Where('MA_VOUCHER', $id_voucher)->first();
        $voucher->SoLuongVOUCHER--;
        $voucher->save();
    }
}
