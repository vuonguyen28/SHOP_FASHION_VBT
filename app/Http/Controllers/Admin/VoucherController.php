<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;


class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voucher = Voucher::all();
        return view('admin.voucher.index', ['voucher' => $voucher]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $voucher = Voucher::where('Ten_VOUCHER', 'like', "%$keyword%")->get();
        return view('admin.voucher.index', compact('voucher'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Kiểm tra xem mã voucher đã tồn tại chưa
            $existingVoucher = Voucher::where('MA_VOUCHER', $request->MA_VOUCHER)->first();
            if ($existingVoucher) {
                return back()->withErrors(['error' => 'Mã voucher đã tồn tại.'])->withInput();
            }

            $validatedData = $request->validate([
                'MA_VOUCHER' => 'required|string',
                'Ten_VOUCHER' => 'required|string',
                'PhanTramGiam' => 'required|numeric',
                'DonToiThieu' => 'required|numeric',
                'GiamToiDa' => 'required|numeric',
                'SoLuongVOUCHER' => 'required|int',
                'Ngaybatdau' => 'required|date',
                'Ngayketthuc' => 'required|date',
            ]);

            Voucher::create($validatedData);

            $voucher = Voucher::all();

            return view('admin.voucher.index', ['voucher' => $voucher, 'success' => 'Thêm Voucher thành công.']);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

   
    public function show(string $id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            return view('admin.voucher.show', ['voucher' => $voucher]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Không tìm thấy voucher.'])->withInput();
        }
    }


    
    public function edit(string $id)
    {
        $voucher = Voucher::where("MA_VOUCHER", $id)->first();
        if (!isset($voucher)) {
            abort(404);
        }
        return view('admin.voucher.edit')->with(['voucher' => $voucher]);
    }

   
    public function update(Request $request, string $id)
    {
        try {
            $voucher = Voucher::findOrFail($id);

            $validatedData = $request->validate([
                'Ten_VOUCHER' => 'required|string',
                'PhanTramGiam' => 'required|numeric',
                'DonToiThieu' => 'required|numeric',
                'GiamToiDa' => 'required|numeric',
                'SoLuongVOUCHER' => 'required|int',
                'Ngaybatdau' => 'required|date',
                'Ngayketthuc' => 'required|date',
            ]);

            $voucher->update($validatedData);
            return redirect()->route('voucher.index')->with('success', 'Cập nhật Voucher thành công.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật Voucher. Vui lòng thử lại sau.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        $voucher = Voucher::all();

        return redirect()->route('voucher.index')->with([
            'voucher' => $voucher,
            'success' => 'Voucher deleted successfully.'
        ]);
    }
}
