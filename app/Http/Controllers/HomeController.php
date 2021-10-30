<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use Redirect;

class HomeController extends Controller
{
    public function index() {
        if (!Auth::check()) return Redirect::route('register');
            
        $products = Product::orderBy('id', 'DESC')->get();
        return view('welcome', compact('products'));
    }
}
