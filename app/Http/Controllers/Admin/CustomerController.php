<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function showCustomers()
    {
        $customers = Customer::where('Role','User')->get();
        return view('admin.customers.show', ['customers' => $customers]);
    }

    // add customers
    public function addCustomerForm()
    {
        return view('admin.customers.addCustomer');
    }

    // add customers 
    public function addCustomer(Request $request)
    {
        // Validate dữ liệu
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
        // Xử lý file ảnh tải lên
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileNameToStore = $file->getClientOriginalName();
            $fileNameToStore = pathinfo($fileNameToStore, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $fileNameToStore);
        } else {
            // Xử lý nếu không có avata
            dd("Không có file avata được tải lên.");
            $fileNameToStore = 'noImage.jpg';
        }

        // Gắn tên tệp hình ảnh vào dữ liệu được xác thực
        $validatedData['avatar'] = $fileNameToStore;
        // Set default role
        $validatedData['Role'] = 'user';
        Customer::create($validatedData);

        // Lấy lại danh sách khách hàng để trả về view
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

        // Nếu có tệp hình mới được tải lên
        if ($request->hasFile('avatar')) {
            // Xóa hình ảnh cũ
            if (file_exists(public_path('avatars/' . $customer->avatar))) {
                unlink(public_path('avatars/' . $customer->avatar));
            }

            // Lưu hình ảnh mới
            $file = $request->file('avatar');
            $fileNameToStore = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $fileNameToStore);

            // Cập nhật avatar mới
            $validatedData['avatar'] = $fileNameToStore;
        } else {
            dd("Không có file avata được tải lên.");
        }

        // Cập nhật thông tin khách hàng
        $customer->update($validatedData);
        return redirect()->route('customers.show')->with('success', 'Customer updated successfully.');
    }
}
