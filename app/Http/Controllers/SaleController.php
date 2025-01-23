<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Sales;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index() {
        return view('sales.index');
    }

    public function create() {
        $products = Product::all();
        #dd($products);
        return view('sales.create', compact('products'));
    }

    public function store() {
        #dd(request()->all());
        $sale = new sales;
        $sale->product_id = request()->product_id;
        $sale->amount = request()->amount;
        $sale->description = request()->description;
        $sale->is_paid = request()->is_paid;
        $sale->save();

        Session::flash('success', trans('message.success_on_update'));
        return redirect()->route('sales.index');
    }
}
