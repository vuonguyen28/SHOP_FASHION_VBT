<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $size = Size::all();
        return view('admin.size.index', ['size' => $size]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.size.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // lay du lieu tu form dua xuong mysql
        // Validate dữ liệu
        $validatedData = $request->validate([
            'TenKichThuoc' => 'required|string',
        ]);
        
        Size::create($validatedData);

        // Lấy lại danh sách khách hàng để trả về view
        $size = Size::all();
        return view('admin.size.index', ['size' => $size, 'success' => 'size added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $size = Size::find($id);
        if (!$size) {
            return redirect()->route('admin.size.index')->with('error', 'Size not found.');
        }
        return view('admin.size.show', compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $size = Size::where("MaKichThuoc", $id)->first();
        if (!isset($size)) {
            abort(404);
        }
        return view('admin.size.edit')->with(['size' => $size]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update du lieu xuong sql
        $size = Size::findOrFail($id);

        // Validate dữ liệu
        $validatedData = $request->validate([
            'TenKichThuoc' => 'required|string',
        ]);

        // Cập nhật thông tin 
        $size->update($validatedData);

        return redirect()->route('size.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //xoa size khoi sql
        $size = Size::findOrFail($id);
        $size->delete();

        $size = Size::all();

        return redirect()->route('size.index')->with([
            'size' => $size,
            'success' => 'Customer deleted successfully.'
        ]);
    }
}

