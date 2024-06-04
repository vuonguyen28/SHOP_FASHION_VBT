<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\ProductDetails;
use Illuminate\Http\Request;

class ProductsDetailsController extends Controller
{
    public function getColorsBySize($sizeId)
    {
        $colors = ProductDetails::where('MaKichThuoc', $sizeId)->pluck('MaMau')->toArray();
        return response()->json($colors);
    }
}
