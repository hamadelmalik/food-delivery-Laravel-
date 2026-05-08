<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

 public function index()
    {
       $products = Product::latest()->get();
        $orders = Order::latest()->get();
        $products = Product::latest()->get();
        $orders = Order::latest()->get();
        $users = User::latest()->get();

        return view('dashboard', compact('products', 'orders', 'users'));
    }
}
