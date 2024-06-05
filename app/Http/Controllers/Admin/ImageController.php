<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    public function index($MaSP)
    {
        $image = Image::where('MaSP', $MaSP)->get();
        return view('admin.image.index', ['image' => $image, 'MaSP' => $MaSP]);
    }

    public function create($MaSP)
    {
        return view('admin.image.create', compact('MaSP'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'MaSP' => 'required|string',
                'hinhanh.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate multiple image files
            ]);

            // Xử lý nhiều file ảnh được tải lên
            if ($request->hasFile('hinhanh')) {
                foreach ($request->file('hinhanh') as $file) {
                    // Tải lên hình ảnh lên Cloudinary
                    $result = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'Shop', // Thư mục trên Cloudinary để lưu trữ hình ảnh
                    ]);
                    // Lưu URL của hình ảnh vào cơ sở dữ liệu
                    Image::create([
                        'MaSP' => $validatedData['MaSP'],
                        'hinhanh' => $result->getSecurePath(), // URL an toàn để truy cập hình ảnh từ Cloudinary
                    ]);
                }
            }

            return redirect()->route('image.show', ['MaSP' => $validatedData['MaSP']])->with('success', 'Hình ảnh đã được thêm thành công.');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return back()->withErrors($errors)->withInput();
        }
    }

    public function show($productId)
    {
        // Tìm sản phẩm theo ID
        // $product = Product::findOrFail($productId);

        // return view('admin.image.show', compact('product'));
    }

    public function edit(string $id)
    {
        $image = Image::where("MaHinhAnh", $id)->first();
        if (!isset($image)) {
            abort(404);
        }
        return view('admin.image.edit')->with(['image' => $image]);
    }

    public function update(Request $request, string $id)
    {
    }
    // public function destroy(Request $request)
    // {
    //     $selectedIds = $request->input('selectedIds');

    //     // Kiểm tra xem có hình ảnh nào được chọn không
    //     if (!empty($selectedIds)) {
    //         foreach ($selectedIds as $id) {
    //             $image = Image::find($id);

    //             // Kiểm tra xem hình ảnh có tồn tại không trước khi xóa
    //             if ($image) {
    //                 // Xóa hình ảnh từ thư mục lưu trữ
    //                 if (file_exists(public_path('product/' . $image->hinhanh))) {
    //                     unlink(public_path('product/' . $image->hinhanh));
    //                 }

    //                 // Xóa hình ảnh khỏi cơ sở dữ liệu
    //                 $image->delete();
    //             }
    //         }

    //         return redirect()->back()->with('success', 'Các hình ảnh đã được xóa thành công.');
    //     } else {
    //         return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một hình ảnh để xóa.');
    //     }
    // }



    public function destroy(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        // Kiểm tra xem có hình ảnh nào được chọn không
        if (!empty($selectedIds)) {
            foreach ($selectedIds as $id) {
                $image = Image::find($id);

                // Kiểm tra xem hình ảnh có tồn tại không trước khi xóa
                if ($image) {
                    // Lấy URL của hình ảnh từ cơ sở dữ liệu
                    $imageUrl = $image->hinhanh;

                    // Trích xuất public ID từ URL hình ảnh
                    preg_match('/\/v\d+\/(.+?)\.[a-zA-Z0-9]{3,4}$/', $imageUrl, $matches);
                    $publicId = isset($matches[1]) ? $matches[1] : null;

                    if ($publicId) {
                        // Xóa hình ảnh từ Cloudinary
                        Cloudinary::destroy($publicId);

                        // Xóa hình ảnh khỏi cơ sở dữ liệu
                        $image->delete();
                    }
                }
            }

            return redirect()->back()->with('success', 'Các hình ảnh đã được xóa thành công.');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một hình ảnh để xóa.');
        }
    }
}
