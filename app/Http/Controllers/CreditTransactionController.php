<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditTransactionController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()
            ->creditTransactions()
            ->latest()
            ->paginate(10);

        return view('credit.index', compact('transactions'));
    }
}
