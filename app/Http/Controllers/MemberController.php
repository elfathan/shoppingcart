<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Product;

class MemberController extends Controller
{
    public function index() {
        if (!Auth::check()) return Redirect::route('register');
        
        return view('member/home');
    }
}
