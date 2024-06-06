<?php

namespace App\Http\Controllers\Account;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\OrderDetails;
use App\Models\ProductDetail;
use App\Models\OrderDetail;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\ProductDetails;


class ProductsController extends Controller
{
    public function showTop8Sale()
    {


        $topProducts = Product::select('sanpham.TenSP', DB::raw('MAX(hinhanh.hinhanh) AS HinhAnh'))
            ->join('chitietsanpham', 'sanpham.MaSP', '=', 'chitietsanpham.MaSP')
            ->join('chitietdonhang', 'chitietsanpham.MaChiTiet', '=', 'chitietdonhang.MaChiTietSanPham')
            ->join('hinhanh', 'sanpham.MaSP', '=', 'hinhanh.MaSP')
            ->groupBy('sanpham.TenSP', 'chitietdonhang.MaChiTietSanPham')
            ->orderByRaw('SUM(chitietdonhang.SoLuong) DESC')
            ->limit(8)
            ->get();
        $products = Product::orderBy('PhanTramGiamGia', 'desc')->take(8)->get();
        return view('account.home.index', compact('products', 'topProducts'));
    }


    public function ShowProduct()
    {
        session()->forget('ProductName');
        $category = Category::all();
        $products = Product::all();
        // Khởi tạo mảng để lưu trữ tổng số lượng đã bán của từng sản phẩm
        $totalSoldPerProduct = [];

        // Duyệt qua tất cả sản phẩm để tính tổng số lượng đã bán của mỗi sản phẩm
        foreach ($products as $product) {
            $totalSold = 0;

            // Duyệt qua tất cả các chi tiết đơn hàng của sản phẩm hiện tại
            foreach ($product->productDetails as $productDetail) {
                // Lấy tất cả các đơn hàng có trạng thái "ĐÃ NHẬN" chứa chi tiết sản phẩm này
                $orders = $productDetail->orderDetails()->whereHas('order', function ($query) {
                    $query->where('TrangThaiDonHang', 'ĐÃ NHẬN');
                })->get();

                // Tính tổng số lượng đã bán của chi tiết sản phẩm này và cộng vào tổng số lượng đã bán của sản phẩm
                $totalSold += $orders->sum('SoLuong');
            }

            // Lưu tổng số lượng đã bán của sản phẩm vào mảng $totalSoldPerProduct
            $totalSoldPerProduct[$product->MaSP] = $totalSold;
        }

        // Sắp xếp mảng $totalSoldPerProduct từ cao đến thấp dựa trên giá trị tổng số lượng đã bán
        arsort($totalSoldPerProduct);

        // Lấy 8 sản phẩm đầu tiên sau khi sắp xếp
        $topProducts = array_slice($totalSoldPerProduct, 0, 8);

        // Lấy thông tin chi tiết của các sản phẩm hàng đầu
        $topProductDetails = Product::whereIn('MaSP', array_keys($topProducts))->get();

        return view('account.products.products', compact('products', 'category', 'topProductDetails'));
    }

    public function SearchProduct(Request $request)
    {

        session()->put("ProductName", $request->ProductName);
        $category = Category::all();
        $products = Product::where('TenSP', 'like', "%$request->ProductName%")->get();
        if ($products->count() == 0) {
            return view('account.products.products', [
                'products' => $products,
                'category' => $category,
                'success' => 'Product does not exist'
            ]);
        }
        return view('account.products.products', compact('products', 'category'));
    }

    public function DisplayProductsByType($id)
    {
        $category = Category::all();
        $products = Product::where('MaDanhMuc', $id)->get();
        return view('account.products.DisplayProductsByType', compact('products', 'category'));
    }

    public function SeeProductDetails($id)
    {
        $productDetails = ProductDetails::where('MaSP', $id)->get();

        $totalSold = 0;

        // Duyệt all ctspham
        foreach ($productDetails as $productDetail) {
            // Lấy tất cả các đơn hàng có trạng thái "ĐÃ NHẬN"  chứa chi tiết sản phẩm này
            $orders = $productDetail->OrderDetails()->whereHas('order', function ($query) {
                $query->where('TrangThaiDonHang', 'ĐÃ NHẬN');
            })->get();

            // Tổng số lượng đã bán của chi tiết sản phẩm này
            $totalSold += $orders->sum('SoLuong');
        }

        $product = Product::with('ProductDetails.OrderDetails.Feedback')->find($id);

        return view('account.products.SeeProductDetails', compact('product', 'productDetails', 'totalSold'));
    }
}
