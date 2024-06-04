<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\ProductDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    
    public function index()
    {
        $cart = Cart::all();
        return view('admin.cart.index', compact('cart'));
    }

    public function create()
    {
        $customer = Customer::all();
        $productdetails = ProductDetails::all();
        return view('admin.cart.create', compact('customer', 'productdetails'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'MaKhachHang' => 'required|int',
            'MaChiTietSanPham' => 'required|int',
            'SoLuong' => 'required|int',
        ]);
        $cart = Cart::create($validatedData);
        return redirect()->route('cart.index')->with('success', 'Product created successfully.');
    }
    
    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $cart = Cart::where("MaGioHang", $id)->first();
        if (!isset($cart)) {
            abort(404);
        }

        $customer = Customer::all();
        $productdetails = ProductDetails::all();

        return view('admin.cart.edit', ['cart' => $cart, 'customer' => $customer, 'productdetails' => $productdetails]);
    }

   
    public function update(Request $request, string $id)
    {
        $cart = Cart::findOrFail($id);
        $validatedData = $request->validate([
            'MaKhachHang' => 'required|int',
            'MaChiTietSanPham' => 'required|int',
            'SoLuong' => 'required|int',
        ]);
        $cart->update($validatedData);

        return redirect()->route('cart.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        $cart = Cart::all();

        return redirect()->route('cart.index')->with([
            'Cart' => $cart,
            'success' => 'Cart deleted successfully.'
        ]);
    }
}
