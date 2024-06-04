<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\ProductDetails;
use App\Models\Color;
use App\Models\Size;
use App\Models\Voucher;
use Illuminate\Support\Facades\Log;
use App\Models\Product;



class ProfileController extends Controller
{
    //
    public function ShowProfile()
    {
        $UserID = session('LoggedUser');
        if (!$UserID) {
            return redirect()->route('login.login')->with('error', 'vui lòng đăng nhập để xem thông tin cá nhân');
        }
        $customer = Customer::findOrFail($UserID);

        return view('account.profile.show_profile', [
            'customer' => $customer,
        ]);
    }


    public function editName(Request $request)
    {
        $UserID = session('LoggedUser');
        if (!$UserID) {
            return redirect()->route('login.login')->with('error', 'vui lòng đăng nhập để xem thông tin cá nhân');
        }
        $customer = Customer::findOrFail($UserID);
        $customer->TenKH = $request->name;
        $customer->save();

        return view('account.profile.show_profile', [
            'customer' => $customer,
            'success' => 'update success <_>!!!!'
        ]);
    }

    public function editPhone(Request $request)
    {
        $UserID = session('LoggedUser');
        if (!$UserID) {
            return redirect()->route('login.login')->with('error', 'vui lòng đăng nhập để xem thông tin cá nhân');
        }
        $customer = Customer::findOrFail($UserID);
        $customer->SoDienThoai = $request->Phone;
        $customer->save();

        return view('account.profile.show_profile', [
            'customer' => $customer,
            'success' => 'update success <_>!!!!'
        ]);
    }

    public function editEmail(Request $request)
    {
        $UserID = session('LoggedUser');
        if (!$UserID) {
            return redirect()->route('login.login')->with('error', 'vui lòng đăng nhập để xem thông tin cá nhân');
        }
        $customer = Customer::findOrFail($UserID);
        $customer->Email = $request->Email;
        $customer->save();

        return view('account.profile.show_profile', [
            'customer' => $customer,
            'success' => 'update success <_>!!!!'
        ]);
    }



    public function editAddress(Request $request)
    {
        $UserID = session('LoggedUser');
        if (!$UserID) {
            return redirect()->route('login.login')->with('error', 'vui lòng đăng nhập để xem thông tin cá nhân');
        }
        $customer = Customer::findOrFail($UserID);
        $customer->DiaChi = $request->Address;
        $customer->save();

        return view('account.profile.show_profile', [
            'customer' => $customer,
            'success' => 'update success <_>!!!!'
        ]);
    }


    public function editgender(Request $request)
    {
        $UserID = session('LoggedUser');
        if (!$UserID) {
            return redirect()->route('login.login')->with('error', 'vui lòng đăng nhập để xem thông tin cá nhân');
        }
        $customer = Customer::findOrFail($UserID);
        $customer->GioiTinh = $request->gender;
        $customer->save();

        return view('account.profile.show_profile', [
            'customer' => $customer,
            'success' => 'update success <_>!!!!'
        ]);
    }



    public function editimage(Request $request)
    {
        $UserID = session('LoggedUser');
        if (!$UserID) {
            return redirect()->route('login.login')->with('error', 'vui lòng đăng nhập để xem thông tin cá nhân');
        }


        $customer = Customer::findOrFail($UserID);

        $validatedData = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if (file_exists(public_path('avatars/' . $customer->avatar))) {
                unlink(public_path('avatars/' . $customer->avatar));
            }

            // Lưu hình ảnh mới
            $file = $request->file('avatar');
            $fileNameToStore = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $fileNameToStore);

            // Cập nhật avatar mới
            $validatedData['avatar'] = $fileNameToStore;

            $customer->update($validatedData);

        } else {
            dd("Không có file avata được tải lên.");
        }

        return view('account.profile.show_profile', [
            'customer' => $customer,
            'success' => 'update success <_>!!!!'
        ]);
    }





    public function editPassword(Request $request)
    {
        $UserID = session('LoggedUser');
        if (!$UserID) {
            return redirect()->route('login.login')->with('error', 'vui lòng đăng nhập để xem thông tin cá nhân');
        }
        $customercheck_pass = Customer::where('Password_hs5', $request->oldPassword)
            ->where('MaKH', $UserID)->first();

        $customer = Customer::findOrFail($UserID);
        if (!$customercheck_pass) {
            return view('account.profile.show_profile', [
                'customer' => $customer,
                'error' => 'mật khẩu cũ không đúng'
            ]);
        } else {
            $customer->Password_hs5 = $request->Password;
            $customer->save();

            return view('account.profile.show_profile', [
                'customer' => $customer,
                'success' => 'update success <_>!!!!'
            ]);
        }
    }
}
