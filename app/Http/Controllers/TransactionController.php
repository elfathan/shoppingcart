<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\UserAddress;
use Session;

class TransactionController extends Controller
{
    public function doCheckout(Request $request) {
        try {
            $carts = Cart::with('product')->where('id_customer', Auth::user()->id)->orderBy('id', 'DESC')->get();
            
            //Store Transaction
            $transaction = new Transaction;
            $transaction->id = $transaction::max('id') + 1;
            $transaction->id_customer = Auth::user()->id;
            $transaction->invoice_number = date('Ymd') . '0000' . $transaction::max('id') + 1;
            $transaction->status = 'waiting';
            $transaction->save();
            
            $subtotal = 0;
            foreach ($carts as $cart) {
                //Store Transaction Detail
                $detail = new TransactionDetail;
                $detail->id = $detail::max('id') + 1;
                $detail->id_transaction = $transaction->id;
                $detail->id_product = $cart->product->id;
                $detail->qty = $cart->qty;
                $detail->status = 'waiting';
                $detail->save();
                
                $subtotal = $subtotal + ($cart->qty * $cart->product->price);
            }
            
            $data = [
                'subtotal' => $subtotal,
                'ongkir' => 15000,
                'total' => $subtotal + 15000,
            ];
            $transaction = Transaction::where('id', $transaction->id)->update($data);
            
            //Store address
            $userExist = UserAddress::where('id_customer', Auth::user()->id)->first();
            if(!$userExist) {
                $userAddress = new UserAddress;
                $userAddress->id = $userAddress::max('id') + 1;
                $userAddress->id_customer = Auth::user()->id;
                $userAddress->address = $request->address;
                $userAddress->status = 'active';
                $userAddress->save();
            } else {
                $data = [
                    'address' => $request->address,
                ];
                $userAddress = UserAddress::where('id_customer', Auth::user()->id)->update($data);
            }
            
            foreach ($carts as $cart) {
                //Update stock product
                $product = Product::where('id', $cart->id_product)->first();
                $data = [
                    'stock' => $product->stock - $cart->qty,
                ];
                $product = Product::where('id', $cart->id_product)->update($data);
            }
            
            //Delete cart
            $cart = Cart::where('id_customer', Auth::user()->id);
            $cart->delete();
            
            return response()->json([
                'message' => 'success',
                'data' => []
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            
            return response()->json([
                'message' => $e,
                'data' => []
            ]);
        }
    }
    
    public function delete(Request $request) {
        $data = [
            'status' => 'rejected',
        ];
        $transaction = Transaction::where('id', $request->id)->update($data);
        
        $carts = TransactionDetail::with('product')->where('id_transaction', $request->id)->get();
        foreach ($carts as $cart) {
            //Update stock product
            $product = Product::where('id', $cart->id_product)->first();
            $data = [
                'stock' => $product->stock + $cart->qty,
            ];
            $product = Product::where('id', $cart->id_product)->update($data);
        }
        
        return response()->json([
            'message' => 'success',
            'data' => []
        ]);
    }
}
