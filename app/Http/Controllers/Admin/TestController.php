<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;



class TestController extends Controller
{
    //
    public function index()
    {



        return view('test');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $result = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'Shop'
            ]);
            $imageUrl = $result->getSecurePath();
            $success = "Thành Công";
            return view('test', ['success' => $success, 'imageUrl' => $imageUrl]);
        }

        $success = "Xàm";
        return view('test', ['success' => $success]);
    }
}
