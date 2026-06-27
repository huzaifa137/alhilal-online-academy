<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentTransaction::with('student')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $s = $request->search;
            $query->whereHas('student', function ($q) use ($s) {
                $q->where('firstname', 'like', "%$s%")
                  ->orWhere('lastname', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%");
            })->orWhere('reference', 'like', "%$s%");
        }

        $payments        = $query->paginate(20);
        $totalRevenue    = PaymentTransaction::where('status', 'completed')->sum('amount');
        $pendingPayments = PaymentTransaction::whereIn('status', ['pending', 'processing'])->count();
        $pendingAmount   = PaymentTransaction::whereIn('status', ['pending', 'processing'])->sum('amount');
        $failedAmount    = PaymentTransaction::where('status', 'failed')->sum('amount');

        return view('Admin.payments.index', compact(
            'payments', 'totalRevenue', 'pendingPayments', 'pendingAmount', 'failedAmount'
        ));
    }

    public function show($id)
    {
        $payment = PaymentTransaction::with('student')->findOrFail($id);
        return view('Admin.payments.show', compact('payment'));
    }
}