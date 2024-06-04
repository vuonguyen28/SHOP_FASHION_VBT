<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategorysController extends Controller
{
    public function ShowCategory()
    {
        $category = Category::all();
        return view('account.layouts.dorpdown_category',compact('category'));
    }
}
