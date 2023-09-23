<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AccountDetail;
use Illuminate\Support\Facades\Auth;

class AccountDetailController extends Controller
{
    public function index(){


        $userId = Auth::id();
        $transactions = AccountDetail::where('user_id', auth()->id())
        ->orderBy('transaction_date', 'desc') // Adjust the order as needed
        ->paginate(10);

        return view('back.pages.transaction.index', compact('transactions'));

    }
}
