<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductDetails;
use App\Models\Voucher;
use App\Models\VoucherToCustomer;

use Illuminate\Support\Facades\Session;

class CartsController extends Controller
{

    public function deleteSessionVoucher()
    {
        session()->forget('sumTotalMoney_SALE');
        session()->forget('nameVoucher');
        session()->forget('sale');
        session()->forget('EndDate');
        session()->forget('MaVoucher');
    }
    public function AddProductToCart(Request $request)
    {
        $validatedData = $request->validate([
            'MaMau' => 'required|string',
            'TenSP' => 'required|string',
            'MaKichThuoc' => 'required|string',
            'MaSP' => 'required|integer',
            'SoLuong' => 'required|integer|min:1',
            'Image' => 'required|string',
        ]);

        try {
            if (!session('LoggedUser')) {
                $productInfo = [
                    'MaSP' => $request->input('MaSP'),
                    'TenSP' => $request->input('TenSP'),
                    'Image' => $request->input('Image'),
                    'MaKichThuoc' => $request->input('MaKichThuoc'),
                    'MaMau' => $request->input('MaMau'),
                    'SoLuong' => $request->input('SoLuong'),
                    'Gia' => $request->input('Gia'),
                    'GiaSale' => $request->input('GiaSale')
                ];

                if (Session::has('cart')) {
                    $cart = Session::get('cart');

                    $productExists = false;
                    foreach ($cart as &$item) {
                        if ($item['MaSP'] == $productInfo['MaSP'] && $item['MaKichThuoc'] == $productInfo['MaKichThuoc'] && $item['MaMau'] == $productInfo['MaMau']) {
                            $item['SoLuong'] += $productInfo['SoLuong'];
                            $productExists = true;
                            break;
                        }
                    }
                    if (!$productExists) {
                        $cart[] = $productInfo;
                    }
                } else {
                    $cart = [$productInfo];
                }
                Session::put('cart', $cart);
            } else {
                $userId = session('LoggedUser');
                $colorID = Color::where('HEXCODE', $request->input('MaMau'))->firstOrFail();
                $SizeID = Size::where('TenKichThuoc', $request->input('MaKichThuoc'))->firstOrFail();

                try {
                    $productDetail = ProductDetails::where('MaMau', $colorID->MaMau)
                        ->where('MaKichThuoc', $SizeID->MaKichThuoc)
                        ->where('MaSP', $request->input('MaSP'))
                        ->firstOrFail();
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Có lỗi xảy ra khi tìm chi tiết sản phẩm: ' . $e->getMessage());
                }

                $quantity = $request->input('SoLuong');

                try {
                    $CartItem = Cart::where('MaKhachHang', $userId)
                        ->where('MaChiTietSanPham', $productDetail->MaChiTiet)
                        ->first();

                    if ($CartItem === null) {
                        // Cart item does not exist, create a new one
                        $cart = new Cart();
                        $cart->MaKhachHang = $userId;
                        $cart->MaChiTietSanPham = $productDetail->MaChiTiet;
                        $cart->SoLuong = $quantity;
                        $cart->save();

                        $this->deleteSessionVoucher();

                        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
                    } else {
                        // Cart item exists, update the quantity
                        $CartItem->SoLuong += $quantity;
                        $CartItem->save();

                        $this->deleteSessionVoucher();
                        return redirect()->back()->with('success', 'Số lượng sản phẩm trong giỏ hàng đã được cập nhật');
                    }
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm vào giỏ hàng: ' . $e->getMessage());
                }
            }

            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
        }
    }

    public function showCart()
    {
        if (!session('LoggedUser')) {
            $cart = session()->get('cart', []);
            return view('account.cart.cart', ['cart' => $cart]);
        } else {

            $vouchers = VoucherToCustomer::where('MaKH',session('LoggedUser'))
            ->where('note','chưa áp dụng')->get();
            $cart = cart::where('MaKhachHang', session('LoggedUser'))->get();
            return view('account.cart.cart', [
                'cart' => $cart,
                'vouchers'=>$vouchers
            ]);
        }
    }

    public function ClearAllCart(Request $request)
    {
        Session::forget('cart');
        return redirect()->back()->with('success', 'Giỏ hàng đã được xóa.');
    }

    public function RemoveProductFromCart(Request $request)
    {
        $productInfo = [
            'MaSP' => $request->input('MaSP'),
            'MaKichThuoc' => $request->input('MaKichThuoc'),
            'MaMau' => $request->input('MaMau'),
        ];

        try {
            // Kiểm tra xem session giỏ hàng có tồn tại hay không
            if (Session::has('cart')) {
                // Lấy thông tin giỏ hàng từ session
                $cart = Session::get('cart');

                // Tìm và xóa sản phẩm khỏi giỏ hàng
                $productFound = false;
                foreach ($cart as $key => $item) {
                    if ($item['MaSP'] == $productInfo['MaSP'] && $item['MaKichThuoc'] == $productInfo['MaKichThuoc'] && $item['MaMau'] == $productInfo['MaMau']) {
                        // Xóa sản phẩm khỏi giỏ hàng
                        unset($cart[$key]);
                        $productFound = true;
                        break;
                    }
                }

                // Cập nhật lại giỏ hàng trong session nếu sản phẩm đã được tìm thấy và xóa
                if ($productFound) {
                    Session::put('cart', $cart);
                    return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
                } else {
                    return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
                }
            } else {
                return redirect()->back()->with('error', 'Giỏ hàng trống.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng.');
        }
    }

    public function increaseProductQuantity(Request $request)
    {
        $productInfo = [
            'MaSP' => $request->input('MaSP'),
            'MaKichThuoc' => $request->input('MaKichThuoc'),
            'MaMau' => $request->input('MaMau'),
        ];

        if (Session::has('cart')) {
            $cart = Session::get('cart');

            foreach ($cart as $key => $item) {
                if ($item['MaSP'] == $productInfo['MaSP'] && $item['MaKichThuoc'] == $productInfo['MaKichThuoc'] && $item['MaMau'] == $productInfo['MaMau']) {
                    $cart[$key]['SoLuong']++;
                    Session::put('cart', $cart);
                }
            }
        }

        return redirect()->back();
    }
    public function decreaseProductQuantity(Request $request)
    {
        $productInfo = [
            'MaSP' => $request->input('MaSP'),
            'MaKichThuoc' => $request->input('MaKichThuoc'),
            'MaMau' => $request->input('MaMau'),
        ];

        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $check=1;

            foreach ($cart as $key => $item) {
                if ($item['MaSP'] == $productInfo['MaSP'] && $item['MaKichThuoc'] == $productInfo['MaKichThuoc'] && $item['MaMau'] == $productInfo['MaMau']) {
                    $cart[$key]['SoLuong']--;
                    if ($cart[$key]['SoLuong'] <= 0) {
                        unset($cart[$key]);
                        $check =0;
                    } 
                    Session::put('cart', $cart);
                    if($check==0)
                    {
                        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
                    }
                }
            }
        }

        return redirect()->back();
    }

    public function updateQuantity(Request $request)
    {
        $productInfo = [
            'MaSP' => $request->input('MaSP'),
            'MaKichThuoc' => $request->input('MaKichThuoc'),
            'MaMau' => $request->input('MaMau'),
        ];

        if (Session::has('cart')) {
            $cart = Session::get('cart');

            foreach ($cart as $key => $item) {
                if ($item['MaSP'] == $productInfo['MaSP'] && $item['MaKichThuoc'] == $productInfo['MaKichThuoc'] && $item['MaMau'] == $productInfo['MaMau']) {
                    $cart[$key]['quantity']--;
                    if ($cart[$key]['quantity'] <= 0) {
                        unset($cart[$key]);
                        $message = 'Sản phẩm đã được xóa khỏi giỏ hàng.';
                    } else {
                        $message = 'Số lượng sản phẩm đã được giảm xuống.';
                    }
                    Session::put('cart', $cart);
                    return redirect()->back()->with('success', $message);
                }
            }
        }

        return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
    }

    public function DeleteCart(int $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->back()->with('success', 'successfully delete a cart product');
    }

    public function AddItemCartProduct(Request $request)
    {
        $cart = Cart::where('MaGioHang',$request->id_cart)->first();
        if($cart)
        {
            $cart->SoLuong ++;
            $cart->save();
            $this->deleteSession();
            return redirect()->back();
        }
        else{
            return redirect()->back()->with('error', 'id not found');
        }
    }

    public function reduceItemCartProduct(Request $request)
    {
        $cart = Cart::where('MaGioHang',$request->id_cart)->first();
        if($cart)
        {
            $cart->SoLuong --;
            $cart->save();
            if( $cart->SoLuong ==0)
            {
                $cart->delete();
                $this->deleteSession();
                return redirect()->back();
            }
            $this->deleteSession();
            return redirect()->back();
        }
        else{
            return redirect()->back()->with('error', 'id not found');
        }
    }

    public function deleteSession()
    {
        session()->forget('sumTotalMoney_SALE');
        session()->forget('nameVoucher');
        session()->forget('sale');
        session()->forget('EndDate');
        session()->forget('MaVoucher');
    }
}
