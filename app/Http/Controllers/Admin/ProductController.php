<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\Category;
use App\Models\Image;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Validation\ValidationException;


class ProductController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $product = Product::where('TenSP', 'like', "%$keyword%")->get();


        // return view('admin.product.index', compact('product'))->with('i', (request()->input('page', 1) - 1) * $perPage)
        //     ->with('perPage', $perPage);
    }

    // public function index()
    // {
    //     $product = Product::all();
    //     return view('admin.product.index', compact('product'));
    // }
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $perPage = $request->input('per_page', 10);

        $query = Product::query();

        if ($keyword) {
            $query->where('TenSP', 'like', "%$keyword%");
        }

        $product = $query->paginate($perPage);

        return view('admin.product.index', compact('product', 'keyword'))
            ->with('perPage', $perPage);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $supplier = Supplier::all();
        return view('admin.product.create', compact('categories', 'supplier'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate dữ liệu sản phẩm
            $validatedData = $request->validate([
                'TenSP' => 'required|string',
                'Gia' => 'required|numeric',
                'PhanTramGiamGia' => 'nullable|numeric',
                'MoTa' => 'required|string',
                'MaDanhMuc' => 'required|int',
                'MaNhaCungCap' => 'required|int',
                'TrinhTrang' => 'required|string',
            ]);

            // Tạo sản phẩm mới
            $product = Product::create($validatedData);

            // Lưu hình ảnh lên Cloudinary
            if ($request->hasFile('hinhanh')) {
                foreach ($request->file('hinhanh') as $file) {
                    // Tải lên hình ảnh lên Cloudinary
                    $result = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'Shop', // Thư mục trên Cloudinary để lưu trữ hình ảnh
                    ]);
                    // Lưu URL của hình ảnh vào cơ sở dữ liệu
                    Image::create([
                        'MaSP' => $product->MaSP,
                        'hinhanh' => $result->getSecurePath(), // URL an toàn để truy cập hình ảnh từ Cloudinary
                    ]);
                }
            }

            // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
            return redirect()->route('product.index')->with('success', 'Product created successfully.');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return back()->withErrors($errors)->withInput();
        }
    }




    /**
     * Display the specified resource.
     */
    public function showImage(string $id)
    {
        //
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        $productDetails = ProductDetails::where('MaSP', $id)->get();

        return view('admin.product.show', compact('product', 'productDetails'));
    }
    public function getProductImages($maSP)
    {
        $product = Product::find($maSP);
        if (!$product) {
            abort(404);
        }

        $images = $product->images;

        return view('product.images', ['product' => $product, 'images' => $images]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::where("MaSP", $id)->first();
        if (!isset($product)) {
            abort(404);
        }

        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.product.edit', ['product' => $product, 'category' => $categories, 'supplier' => $suppliers]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $product = Product::findOrFail($id);

        // Validate dữ liệu
        $validatedData = $request->validate([
            'TenSP' => 'required|string',
            'Gia' => 'required|numeric',
            'PhanTramGiamGia' => 'nullable|numeric',
            'MoTa' => 'required|string',
            'MaDanhMuc' => 'required|int',
            'MaNhaCungCap' => 'required|int',
            'TrinhTrang' => 'required|string',
        ]);

        // Cập nhật thông tin khách hàng
        $product->update($validatedData);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $images = Image::where('MaSP', $id)->get();
        foreach ($images as $image) {
            $filePath = public_path('product') . '/' . $image->hinhanh;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $image->delete();
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product and associated images deleted successfully.');
    }
    public function destroy_all(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        if (!empty($selectedIds)) {
            foreach ($selectedIds as $id) {
                $product = Product::findOrFail($id);

                if ($product) {
                    $images = Image::where('MaSP', $id)->get();
                    foreach ($images as $image) {
                        $filePath = public_path('product') . '/' . $image->hinhanh;
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                        $image->delete();
                    }
                    $product->delete();
                }
            }
            return response()->json(['success' => true, 'message' => 'Product deletion was successful .']);
        } else {
            return response()->json(['success' => false, 'message' => '产品删除成功.'], 400);
        }
    }

    /**
     * import data form excel
     */

    public function import()
    {
        return view('admin.product.import');
    }
    public function importFromExcel(Request $request)
    {
        // Kiểm tra nếu có file import được gửi lên
        if ($request->hasFile('import_file')) {
            // Validate file import
            $request->validate([
                'import_file' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls',
                ],
            ]);

            // Thực hiện import dữ liệu từ file Excel
            Excel::import(new ProductImport, $request->file('import_file'));

            // Chuyển hướng về trang danh sách sản phẩm sau khi import thành công
            return redirect()->route('product.index')->with('success', 'Import file successfully.');
        } else {
            // Nếu không có file import được gửi lên, chuyển hướng về trang trước và hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Please choose a file to import.');
        }
    }
}
