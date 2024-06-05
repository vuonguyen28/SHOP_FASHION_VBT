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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;




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
        $userID = session('LoggedUser');

        if (!$userID) {
            return redirect()->route('login.login')->with('error', 'Vui lòng đăng nhập để xem thông tin cá nhân');
        }

        $customer = Customer::findOrFail($userID);

        $validatedData = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            try {
                $result = Cloudinary::upload($request->file('avatar')->getRealPath(), [
                    'folder' => 'Avatar',
                ]);

                if ($customer->avatar) {
                    preg_match('/\/v\d+\/(.+?)\.[a-zA-Z0-9]{3,4}$/', $customer->avatar, $matches);
                    $publicId = isset($matches[1]) ? $matches[1] : null;
                    if ($publicId) {
                        Cloudinary::destroy($publicId);
                    }
                }

                $customer->avatar = $result->getSecurePath();
                $customer->save();

                return redirect()->route('account.profile.show_profile', ['customer' => $customer])->with('success', 'Avatar đã được cập nhật thành công');
            } catch (\Exception $e) {
                return back()->withErrors(['avatar' => 'Không thể cập nhật avatar, vui lòng thử lại.']);
            }
        }

        return back()->withErrors(['avatar' => 'Vui lòng chọn một hình ảnh để cập nhật avatar.']);
    }





    // $customer = Customer::findOrFail($id);

    //     // Validate dữ liệu
    //     $validatedData = $request->validate([
    //         'TenKH' => 'required|string',
    //         'SoDienThoai' => 'required|string',
    //         'Email' => 'required|email',
    //         'DiaChi' => 'required|string',
    //         'Password_hs5' => 'required|string',
    //         'GioiTinh' => 'required|in:Nam,Nữ',
    //         'TrangThai' => 'required|boolean',
    //         'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     if ($request->hasFile('avatar')) {
    //         try {
    //             $result = Cloudinary::upload($request->file('avatar')->getRealPath(), [
    //                 'folder' => 'Avatar',
    //             ]);

    //             if ($customer) {
    //                 $imageUrl = $customer->avatar;

    //                 preg_match('/\/v\d+\/(.+?)\.[a-zA-Z0-9]{3,4}$/', $imageUrl, $matches);
    //                 $publicId = isset($matches[1]) ? $matches[1] : null;

    //                 if ($publicId) {
    //                     Cloudinary::destroy($publicId);
    //                 }
    //             }

    //             $validatedData['avatar'] = $result->getSecurePath();
    //         } catch (\Exception $e) {
    //             return back()->withErrors(['success' => 'Failed to update avatar.']);
    //         }
    //     }

    //     $customer->update($validatedData);



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
