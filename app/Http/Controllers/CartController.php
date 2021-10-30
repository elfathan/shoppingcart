<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\UserAddress;
use Redirect;
use Session;

class CartController extends Controller
{
    public function index() {
        if (!Auth::check()) return Redirect::route('register');
        
        $carts = Cart::with('product')->where('id_customer', Auth::user()->id)->orderBy('id', 'DESC')->get();
        
        $subtotal = 0;
        foreach ($carts as $cart) {
            $subtotal = $subtotal + ($cart->qty * $cart->product->price);
        }
        
        return view('member/cart', compact('carts', 'subtotal'));
    }
    
    public function cart() {
        $carts = Cart::with('product')->where('id_customer', Auth::user()->id)->orderBy('id', 'DESC')->get();
        
        return response()->json([
            'message' => 'success',
            'data' => $carts
        ]);
    }

    public function addToCart(Request $request) {
        $isExist = Cart::where('id_product', $request->id)->where('id_customer', Auth::user()->id)->first();
        
        if ($isExist) {
            $cart = Cart::where('id_product', $request->id)->first();
        
            $data = [
                'qty' => $cart->qty + 1,
            ];
            $cart = Cart::where('id_product', $request->id)->update($data);
        } else {
            $product = Product::where('id', $request->id)->first();
        
            $cart = new Cart;
            $cart->id = $cart::max('id') + 1;
            $cart->id_product = $product->id;
            $cart->id_customer = Auth::user()->id;
            $cart->qty = 1;
            $cart = $cart->save(); 
        }
        
        return response()->json([
            'message' => 'success',
            'data' => $cart
        ]);
    }
    
    public function reduceQty(Request $request) {
        $cart = Cart::where('id', $request->id)->first();
        
        if ($cart->qty == 1) {
            $cart = Cart::findOrFail($request->id);
            $cart->delete();
        } else {
            $data = [
                'qty' => $cart->qty - 1,
            ];
            $cart = Cart::where('id', $request->id)->update($data);
        }
        return response()->json([
            'message' => 'success',
            'data' => $cart
        ]);
    }
    
    public function addQty(Request $request) {
        $cart = Cart::where('id', $request->id)->first();
        
        $data = [
            'qty' => $cart->qty + 1,
        ];
        $cart = Cart::where('id', $request->id)->update($data);
        
        return response()->json([
            'message' => 'success',
            'data' => $cart
        ]);
    }
    
    public function delete(Request $request) {
        $cart = Cart::findOrFail($request->id);
        $cart->delete();
        
        return response()->json([
            'message' => 'success',
            'data' => []
        ]);
    }
    
    public function history() {
        if (!Auth::check()) return Redirect::route('register');
        
        $histories = Transaction::where('id_customer', Auth::user()->id)->orderBy('id', 'DESC')->get();
        
        return view('member/history', compact('histories'));
    }
    
    public function checkout() {
        if (!Auth::check()) return Redirect::route('register');
        
        $carts = Cart::with('product')->where('id_customer', Auth::user()->id)->orderBy('id', 'DESC')->get();
        
        $subtotal = 0;
        foreach ($carts as $cart) {
            $subtotal = $subtotal + ($cart->qty * $cart->product->price);
        }
        
        return view('member/checkout', compact('carts', 'subtotal'));
    }
    
    public function historyDetail($id) {
        if (!Auth::check()) return Redirect::route('register');
        
        $carts = TransactionDetail::with('product')->where('id_transaction', $id)->orderBy('id', 'DESC')->get();
        
        $transaction = Transaction::where('id', $id)->first();
        $subtotal = $transaction->subtotal;
        
        $address = UserAddress::where('id_customer', Auth::user()->id)->first();
        $address = $address->address;
        
        return view('member/history-detail', compact('carts', 'subtotal', 'address'));
    }
}
