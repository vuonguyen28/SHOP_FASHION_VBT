<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //show view
        $category = Category::all();
        return view('admin.category.index', ['category' => $category]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //hien thi form tao moi category
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // lay du lieu tu form dua xuong mysql
        // Validate dữ liệu
        $validatedData = $request->validate([
            'TenDanhMuc' => 'required|string',
        ]);

        Category::create($validatedData);

        // Lấy lại danh sách khách hàng để trả về view
        $category = category::all();
        return view('admin.category.index', ['category' => $category, 'success' => 'category added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.category.index')->with('error', 'Category not found.');
        }
        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::where("MaDanhMuc", $id)->first();
        if (!isset($category)) {
            abort(404);
        }
        return view('admin.category.edit')->with(['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update du lieu xuong sql
        $category = Category::findOrFail($id);

        // Validate dữ liệu
        $validatedData = $request->validate([
            'TenDanhMuc' => 'required|string',
        ]);

        // Cập nhật thông tin khách hàng
        $category->update($validatedData);

        return redirect()->route('category.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //xoa category khoi sql
        $category = Category::findOrFail($id);
        $category->delete();

        $category = Category::all();

        return redirect()->route('category.index')->with([
            'category' => $category,
            'success' => 'Customer deleted successfully.'
        ]);
    }
}
