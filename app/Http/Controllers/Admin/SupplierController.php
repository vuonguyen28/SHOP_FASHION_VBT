<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::all();
        return view('admin.supplier.index', ['supplier' => $supplier]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // lay du lieu tu form dua xuong mysql
        // Validate dữ liệu
        $validatedData = $request->validate([
            'TenNhaCungCap' => 'required|string',
            'DiaChi' => 'required|string',
            'SoDienThoai' => 'required|string',
        ]);
        
        Supplier::create($validatedData);

        // Lấy lại danh sách khách hàng để trả về view
        $supplier = Supplier::all();
        return view('admin.supplier.index', ['supplier' => $supplier, 'success' => 'supplier added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return redirect()->route('admin.supplier.index')->with('error', 'Supplier not found.');
        }
        return view('admin.supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::where("MaNhaCungCap", $id)->first();
        if (!isset($supplier)) {
            abort(404);
        }
        return view('admin.supplier.edit')->with(['supplier' => $supplier]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update du lieu xuong sql
        $supplier = Supplier::findOrFail($id);

        // Validate dữ liệu
        $validatedData = $request->validate([
            'TenNhaCungCap' => 'required|string',
            'DiaChi' => 'required|string',
            'SoDienThoai' => 'required|string',
        ]);

        // Cập nhật thông tin khách hàng
        $supplier->update($validatedData);

        return redirect()->route('supplier.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //xoa supplier khoi sql
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        $supplier = Supplier::all();

        return redirect()->route('supplier.index')->with([
            'supplier' => $supplier,
            'success' => 'Customer deleted successfully.'
        ]);
    }
}
