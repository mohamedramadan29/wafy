<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\front\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Order::with('seller','buyer')->orderBy('id','desc')->get();
        return view('admin.transactions.index',compact('transactions'));
    }
    public function show($id)
    {
        $transaction = Order::with('seller','buyer','question')->where('id',$id)->first();
        return view('admin.transactions.show',compact('transaction'));
    }

    public function steps()
    {
        return 'steps';
    }
}
