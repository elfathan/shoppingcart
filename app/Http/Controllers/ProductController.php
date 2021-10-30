<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Redirect;

class ProductController extends Controller
{
    public function detail($id) {
        if (!Auth::check()) return Redirect::route('register');
        
        $detail = Product::where('id', $id)->first();
        $products = Product::where('id', '<>', $id)->get();
        return view('product/detail', compact('detail', 'products'));
    }
    
    public function product() {
        $products = Product::orderBy('id', 'DESC')->get();
        
        return response()->json([
            'message' => 'success',
            'data' => $products
        ]);
    }
    
    public function productDetail($id) {
        $detail = Product::where('id', $id)->first();
        
        return response()->json([
            'message' => 'success',
            'data' => $detail
        ]);
    }
}
