<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $carts = Cart::with('product')->where('id_customer', Auth::user()->id)->orderBy('id', 'DESC')->get();
                View::share(['member' => Auth::user(), 'cartTotal' => count($carts), 'cartHeader' => $carts]);
            }
            return $next($request);
        });
    }
}
