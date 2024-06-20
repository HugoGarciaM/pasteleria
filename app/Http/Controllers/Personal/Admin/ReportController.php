<?php

namespace App\Http\Controllers\Personal\Admin;

use App\Http\Controllers\Controller;
use App\Models\Detail_product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $topCustomers = Detail_product::join('transactions', 'detail_products.transaction_id', '=', 'transactions.id')
            ->join('users', 'transactions.customer', '=', 'users.id')
            ->selectRaw('users.id as customer_id, SUM(detail_products.quantity) as total_quantity, SUM(detail_products.quantity * detail_products.price) as total_revenue')
            ->groupBy('users.id')
            ->orderBy('total_quantity', 'desc')
            ->get();

        $dailyEarnings = Detail_product::join('transactions', 'detail_products.transaction_id', '=', 'transactions.id')
            ->selectRaw('DATE(transactions.created_at) as date, SUM(detail_products.quantity * detail_products.price) as total_revenue')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();


        $mostSoldProducts = Detail_product::selectRaw('product_id, SUM(quantity) as total_quantity, SUM(quantity * price) as total_revenue')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->with('product')
            ->get();

        $transactions = Transaction::selectRaw('DATE(created_at) as dat, COUNT(*) as total')
            ->groupBy('dat')
            ->orderBy('dat', 'asc')
            ->get();

        $dataPoints = [];
        $dataPoints1 = [];
        foreach ($dailyEarnings as $earnings) {
            $dataPoints1[]=[
                'y'=> $earnings->total_revenue,
                'label'=> $earnings->date
            ];
        }
        foreach ($transactions as $transaction) {
            $dataPoints[] = [
                'label' => $transaction->dat,
                'y' => $transaction->total
            ];
        }
        return view('personal.admin.report',[
            'dataPoints'=>$dataPoints,
            'products'=>$mostSoldProducts,
            'dataPoints1'=>$dataPoints1,
            'top' => $topCustomers
        ]);
    }
}
