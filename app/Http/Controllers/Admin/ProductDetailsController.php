<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Color;
use App\Models\ProductDetails;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productDetail = ProductDetails::all();
        return view('admin.productdetails.index', compact('productDetail'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $product = Product::find($request->MaSP); // Tìm sản phẩm theo MaSP từ request
        $sizes = Size::all();
        $colors = Color::all();

        return view('admin.productdetails.create', compact('product', 'sizes', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'MaSP' => 'required|int',
            'MaKichThuoc' => 'required|int',
            'MaMau' => 'required|int',
            'SoLuongTon' => 'required|int',
        ]);
        $existingProductDetail = ProductDetails::where('MaSP', $validatedData['MaSP'])
            ->where('MaKichThuoc', $validatedData['MaKichThuoc'])
            ->where('MaMau', $validatedData['MaMau'])
            ->first();

        if ($existingProductDetail) {
            $existingProductDetail->SoLuongTon += $validatedData['SoLuongTon'];
            $existingProductDetail->save();
        } else {
            ProductDetails::create($validatedData);
        }

        return redirect()->route('product.show', ['id' => $validatedData['MaSP']]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productdetails = ProductDetails::where("MaChiTiet", $id)->first();
        if (!isset($productdetails)) {
            abort(404);
        }

        $product = Product::all();
        $size = Size::all();
        $color = Color::all();
        return view('admin.productdetails.edit', ['productdetails' => $productdetails, 'product' => $product, 'size' => $size, 'color' => $color]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'MaSP' => 'required|int',
            'MaKichThuoc' => 'required|int',
            'MaMau' => 'required|int',
            'SoLuongTon' => 'required|int',
        ]);

        $productdetails = ProductDetails::findOrFail($id);
        $productdetails->update($validatedData);

        return redirect()->route('product.show', ['id' => $validatedData['MaSP']]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productDetail = ProductDetails::findOrFail($id);

        $productId = $productDetail->MaSP; // Lấy mã sản phẩm trước khi xóa

        $productDetail->delete();

        // Chuyển hướng về trang hiển thị chi tiết sản phẩm của sản phẩm được xóa
        return redirect()->route('product.show', ['id' => $productId])->with('success', 'Product detail deleted successfully.');
    }


    public function getSizesByColor(Request $request)
    {
        $color = $request->input('color');

        // Lấy kích thước có số lượng tồn lớn hơn 0 cho màu đã chọn
        $sizes = ProductDetails::with('Size')
            ->whereHas('Color', function ($query) use ($color) {
                $query->where('TenMau', $color);
            })
            ->where('SoLuongTon', '>', 0)
            ->get();

        return view('sizes', compact('sizes'));
    }
}
