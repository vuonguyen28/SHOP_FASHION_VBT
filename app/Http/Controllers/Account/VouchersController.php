<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\VoucherToCustomer;
use Carbon\Carbon;

class VouchersController extends Controller
{
    public function ShowVoucher()
    {
        $vouchers = Voucher::notSavedByCustomer(session('LoggedUser'))
                                      
                            ->get();
        return view('account.voucher.showVoucher', compact('vouchers'));
    }

    public function MyVoucher()
    {
        if (!session('LoggedUser')) {
            return redirect()->route('login.ShowLoginForm')->with(['error' => 'Vui lòng đăng nhập xem voucher']);
        }
        else{
            $vouchers = VoucherToCustomer::where('MaKH',session('LoggedUser')) 
                                        ->where('note','chưa áp dụng') 
                                        ->get();
        }
        return view('account.voucher.myVoucher', compact('vouchers'));
    }

    public function MyVoucherLayout()
    {
        if (!session('LoggedUser')) {
            return redirect()->route('login.ShowLoginForm')->with(['error' => 'Vui lòng đăng nhập xem voucher']);
        }
        else{
            $vouchers = VoucherToCustomer::where('MaKH',session('LoggedUser')) 
                                        ->where('note','chưa áp dụng') 
                                        ->get();
        }
        return view('account.voucher.my_voucher_layout', compact('vouchers'));
    }

    public function AddVoucherToCustomer(Request $request)
    {
        $request->validate([
            'MaVoucher' => 'required|string',
        ]);

        $voucher = Voucher::where('MA_VOUCHER', $request->MaVoucher)->first();
        if (!$voucher) {
            return redirect()->back()->with(['error' => 'Voucher không tồn tại']);
        }

        if (!session('LoggedUser')) {
            return redirect()->route('login.ShowLoginForm')->with(['error' => 'Vui lòng đăng nhập để lưu voucher']);
        }

        $checkVoucher = VoucherToCustomer::where('MaKH', session('LoggedUser'))
            ->where('MA_VOUCHER', $request->MaVoucher)
            ->first();

        if ($checkVoucher) {
            return redirect()->back()->with(['error' => 'Voucher đã được gán cho khách hàng này']);
        }

        VoucherToCustomer::create([
            'MaKH' => session('LoggedUser'),
            'MA_VOUCHER' => $request->MaVoucher,
            'note' => 'chưa áp dụng',
        ]);

        return redirect()->back()->with(['success' => 'Lưu voucher thành công']);
    }

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucherCode' => 'required|string'
        ]);

        $voucherCode = $request->input('voucherCode');
        $sumTotalMoney = $request->input('sumTotalMoney');

        $voucher = Voucher::where('MA_VOUCHER', $voucherCode)->first();

        if ($voucher) {
            $currentDateTime = Carbon::now();
            $voucherEndDate = Carbon::parse($voucher->Ngayketthuc);

            if (!$voucherEndDate->greaterThanOrEqualTo($currentDateTime)) {
                return redirect()->back()->with('error', 'VOUCHER đã hết hạn sử dụng.');
            } else {
                $sale = $voucher->PhanTramGiam;
                $sumTotalMoney_SALE = ($sumTotalMoney * $sale) / 100;

                session()->put('sumTotalMoney_SALE', $sumTotalMoney_SALE);
                session()->put('nameVoucher',$voucher->Ten_VOUCHER);
                session()->put('sale', $sale);
                session()->put('EndDate', $voucher->Ngayketthuc);
                session()->put('MaVoucher', $voucher->MA_VOUCHER);

               
                return redirect()->back()->with([
                    'success' => 'Apply voucher success!.'
                ]);
            }
        } else {
            return redirect()->back()->with(['error' => 'Mã voucher không hợp lệ.']);
        }
    }

    
    
    public function deleteVoucherApplyToOrder()
    {
        session()->forget('sumTotalMoney_SALE');
        session()->forget('nameVoucher');
        session()->forget('sale');
        session()->forget('EndDate');
        session()->forget('MaVoucher');

        return redirect()->back();
    }
}
