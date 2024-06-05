<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function showCustomers()
    {
        $customers = Customer::where('Role', 'User')->get();
        return view('admin.customers.show', ['customers' => $customers]);
    }

    // add customers
    public function addCustomerForm()
    {
        return view('admin.customers.addCustomer');
    }

    // add customers 
    // public function addCustomer(Request $request)
    // {
    //     // Validate dữ liệu
    //     $validatedData = $request->validate([
    //         'TenKH' => 'required|string',
    //         'SoDienThoai' => 'required|string',
    //         'Email' => 'required|email',
    //         'DiaChi' => 'required|string',
    //         'Password_hs5' => 'required|string',
    //         'GioiTinh' => 'required|in:Nam,Nữ',
    //         'TrangThai' => 'required|boolean',
    //         'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

    //     ]);
    //     // Xử lý file ảnh tải lên
    //     if ($request->hasFile('avatar')) {
    //         $file = $request->file('avatar');
    //         $fileNameToStore = $file->getClientOriginalName();
    //         $fileNameToStore = pathinfo($fileNameToStore, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('avatars'), $fileNameToStore);
    //     } else {
    //         // Xử lý nếu không có avata
    //         dd("Không có file avata được tải lên.");
    //         $fileNameToStore = 'noImage.jpg';
    //     }

    //     // Gắn tên tệp hình ảnh vào dữ liệu được xác thực
    //     $validatedData['avatar'] = $fileNameToStore;
    //     // Set default role
    //     $validatedData['Role'] = 'user';
    //     Customer::create($validatedData);

    //     // Lấy lại danh sách khách hàng để trả về view
    //     $customers = Customer::all();
    //     return view('admin.customers.show', ['customers' => $customers, 'success' => 'Customer added successfully.']);
    // }




    public function addCustomer(Request $request)
    {
        // Validate the data
        $validatedData = $request->validate([
            'TenKH' => 'required|string',
            'SoDienThoai' => 'required|string',
            'Email' => 'required|email',
            'DiaChi' => 'required|string',
            'Password_hs5' => 'required|string',
            'GioiTinh' => 'required|in:Nam,Nữ',
            'TrangThai' => 'required|boolean',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $result = Cloudinary::upload($request->file('avatar')->getRealPath(), [
                'folder' => 'Avatar',
            ]);

            $validatedData['avatar'] = $result->getSecurePath();
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['avatar' => 'Failed to upload avatar.']);
        }

        $validatedData['Role'] = 'user';

        Customer::create($validatedData);

        $customers = Customer::all();

        return view('admin.customers.show', ['customers' => $customers, 'success' => 'Customer added successfully.']);
    }

    // delete customer
    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);

        // Xóa file hình ảnh nếu tồn tại
        if (file_exists(public_path('avatars/' . $customer->avatar))) {
            unlink(public_path('avatars/' . $customer->avatar));
        }

        $customer->delete();

        $customers = Customer::all();

        return redirect()->route('customers.show')->with([
            'customers' => $customers,
            'success' => 'Customer deleted successfully.'
        ]);
    }
    public function editCustomerForm($customerId)
    {
        $customer = Customer::where("MaKH", $customerId)->first();
        if (!isset($customer)) {
            abort(404);
        }
        return view('admin.customers.editCustomer')->with(['customer' => $customer]);
    }
    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        // Validate dữ liệu
        $validatedData = $request->validate([
            'TenKH' => 'required|string',
            'SoDienThoai' => 'required|string',
            'Email' => 'required|email',
            'DiaChi' => 'required|string',
            'Password_hs5' => 'required|string',
            'GioiTinh' => 'required|in:Nam,Nữ',
            'TrangThai' => 'required|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            try {
                $result = Cloudinary::upload($request->file('avatar')->getRealPath(), [
                    'folder' => 'Avatar',
                ]);

                if ($customer) {
                    $imageUrl = $customer->avatar;

                    preg_match('/\/v\d+\/(.+?)\.[a-zA-Z0-9]{3,4}$/', $imageUrl, $matches);
                    $publicId = isset($matches[1]) ? $matches[1] : null;

                    if ($publicId) {
                        Cloudinary::destroy($publicId);
                    }
                }
               
                $validatedData['avatar'] = $result->getSecurePath();
            } catch (\Exception $e) {
                return back()->withErrors(['success' => 'Failed to update avatar.']);
            }
        }

        $customer->update($validatedData);

        return redirect()->route('customers.show')->with('success', 'Customer updated successfully.');
    }



    private function getPublicIdFromUrl($imageUrl)
    {
        // Trích xuất public ID từ URL hình ảnh
        preg_match('/\/v\d+\/(.+?)\.[a-zA-Z0-9]{3,4}$/', $imageUrl, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
}
