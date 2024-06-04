<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $color = Color::all();
        return view('admin.color.index', ['color' => $color]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Color.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'TenMau' => 'required|string',
            'HEXCODE' => 'required|string',
        ]);
        
        Color::create($validatedData);
        $color = Color::all();
        return view('admin.Color.index', ['color' => $color, 'success' => 'Color added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $color = Color::find($id);
        if (!$color) {
            return redirect()->route('admin.color.index')->with('error', 'color not found.');
        }
        return view('admin.color.show', compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $color = Color::where("MaMau", $id)->first();
        if (!isset($color)) {
            abort(404);
        }
        return view('admin.Color.edit')->with(['Color' => $color]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Color = Color::findOrFail($id);
        $validatedData = $request->validate([
            'TenMau' => 'required|string',
            'HEXCODE' => 'required|string',
        ]);

        $Color->update($validatedData);

        return redirect()->route('Color.index')->with('success', 'Color updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        $color = Color::all();

        return redirect()->route('Color.index')->with([
            'Color' => $color,
            'success' => 'Color deleted successfully.'
        ]);
    }
}
