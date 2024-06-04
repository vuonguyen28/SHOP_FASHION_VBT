<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function ShowProfile()
    {
        return view('account.profile.show_profile');
    }
}
