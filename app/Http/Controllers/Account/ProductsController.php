<?php

namespace App\Http\Controllers\Account;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductDetails;


class ProductsController extends Controller
{
    public function showTop8Sale()
    {
        $products = Product::orderBy('PhanTramGiamGia', 'desc')->take(8)->get();
        return view('account.home.index', compact('products'));
    }


    public function ShowProduct()
    {
        session()->forget('ProductName');
        $category = Category::all();
        $products = Product::all();
        

        return view('account.products.products', compact('products', 'category'));
    }

    public function SearchProduct(Request $request)
    {
        
        session()->put("ProductName",$request->ProductName);
        $category = Category::all();
        $products = Product::where('TenSP','like', "%$request->ProductName%" )->get();
        if($products->count()==0)
        {
            return view('account.products.products', [
                'products' => $products,
                'category'=>$category,
                'success'=>'Product does not exist'
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
        //$product = Product::findOrFail($id);
        $productDetails = ProductDetails::where('MaSP', $id)->get();

        $product = Product::with('ProductDetails.OrderDetails.Feedback')->find($id);

        return view('account.products.SeeProductDetails', compact('product', 'productDetails'));
    }
    
}
