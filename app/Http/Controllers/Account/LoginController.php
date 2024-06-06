<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
class LoginController extends Controller
{
    public function ShowLoginForm()
    {
        return view('account.login.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('Password_hs5');

        

        $customer = Customer::where('Email', $email)->first();

        if($customer->TrangThai == '0'){
            return redirect()->back()->with('error', 'Tài khoản đã bị khóa');
        }

        if ($customer) {
            // if(password_verify($password, $customer->Password_hs5)) { // này kiểm tra passwword mã hõa
            if ($password == $customer->Password_hs5) {
                if ($customer->Role == 'user') {
                    session()->put("LoggedUser", $customer->MaKH);
                    session()->put("LoggedEmail", $customer->Email);
                    session()->put("LoggedName", $customer->TenKH);
                    session()->put("LoggedAddress",$customer->DiaChi);
                    session()->put("LoggedPhone",$customer->SoDienThoai);
                    session()->put("Avatar",$customer->Avatar);


                    return redirect()->route('product.top-8-sale');
                } else {
                    session()->put("LoggedID_Admin", $customer->MaKH);
                    session()->put("LoggedName_Admin", $customer->TenKH);
                    return redirect()->route('customers.show');
                }
            } else {
                return redirect()->back()->with('error', 'Mật khẩu không chính xác');
            }
        } else {
            return redirect()->back()->with('error', 'Email không tồn tại');
        }
    }

    public function LogOut(Request $request)
    {
        $request->session()->forget('LoggedUser');
        $request->session()->forget('LoggedEmail');
        $request->session()->forget('LoggedName');

        session()->forget('sumTotalMoney_SALE');
        session()->forget('nameVoucher');
        session()->forget('sale');
        session()->forget('EndDate');
        session()->forget('MaVoucher');

        return redirect()->route('product.top-8-sale');
    }

    public function Register(Request $request)
    {

        $CustomerEmail = Customer::where('Email', $request->email)->first();
        $CustomerRole = Customer::where('Email', $request->email)
                                ->where('Role','Walk In Cus')->first();
        if (!$CustomerEmail) {
            // Create Customer
            $Customer = Customer::create([
                'TenKH' => $request->username,
                'Email' => $request->email,
                'Password_hs5' => $request->Password_hs5,
                'TrangThai' => '1',
                'avatar' => 'user.png',
                'Role' => 'user',
            ]);
            return redirect()->back()->with('success', 'Customer registered successfully!');
        }else{
            if($CustomerRole)
            {
                $CustomerRole->Password_hs5 = $request->Password_hs5;
                $CustomerRole->Role = 'user';
                $CustomerRole->save();

                return redirect()->back()->with('success', 'The current customer account has successfully changed user status!');
            }
            else{
                return redirect()->back()->with('error', 'Email already exists!');
            }
        }

        return redirect()->back()->with('success', 'Customer registered successfully!');
    }

    public function ForgotPassword(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
        ]);
        $Customer = Customer::where('Email', $request->input('email'))->first();
        if($Customer){
            $email = $request->input('email');

            $password = random_int(100000,999999);

            // Thực hiện gửi email hoặc các xử lý khác
            Mail::raw('Your new password: ' . $password, function ($message) use ($email) {
                $message->to($email)
                        ->subject('Your New Password');
            });
            
            $Customer->Password_hs5 = $password;
            $Customer->save();
    
            return response()->json(['message' => 'New password has been sent to your email']);
        }else{
            return response()->json(['error' => 'Email not found']);
        }
        
    }

}
