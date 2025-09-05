<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use PDF;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function index()
    {
        $allSales = Sale::with('customer', 'items.product')->latest()->get();
        $dueSales = Sale::with('customer', 'items.product')->where('due_amount', '>', 0)->latest()->get();
        $customers = Customer::all();
        return view('backend.report.index', compact('allSales', 'dueSales', 'customers'));
    }

    // Date-wise
    public function datewise(Request $request)
    {
       // Validate input
    $request->validate([
        'start_date' => 'required|date',
        'end_date'   => 'required|date',
    ]);

    // Start of day / end of day
    $start = Carbon::parse($request->start_date)->startOfDay();
    $end   = Carbon::parse($request->end_date)->endOfDay();

    // Fetch sales between start and end datetime
    $sales = Sale::whereBetween('sold_at', [$start, $end])
                 ->orderBy('sold_at', 'desc')
                 ->get();

    // Return partial view for AJAX
    return view('backend.report.partials.datewise', compact('sales'))->render();
    }

    public function datewisePDF(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
    $end   = Carbon::parse($request->end_date)->endOfDay();

    // Fetch sales between start and end datetime
    $sales = Sale::whereBetween('sold_at', [$start, $end])
                 ->orderBy('sold_at', 'desc')
                 ->get();
        $pdf = PDF::loadView('backend.report.pdf.datewise', compact('sales'));
        return $pdf->download('sales_datewise.pdf');
    }

    // Customer-wise
    public function customerwise(Request $request)
    {
        $sales = Sale::with('customer', 'items.product')
            ->where('customer_id', $request->customer_id)
            ->latest()->get();
        return view('backend.report.partials.customerwise', compact('sales'));
    }

    public function customerwisePDF(Request $request)
    {
        $sales = Sale::with('customer', 'items.product')
            ->where('customer_id', $request->customer_id)
            ->latest()->get();
        $pdf = PDF::loadView('backend.report.pdf.customerwise', compact('sales'));
        return $pdf->download('sales_customerwise.pdf');
    }

    // All PDF
    public function allPDF()
    {
        $sales = Sale::with('customer', 'items.product')->latest()->get();
        $pdf = PDF::loadView('backend.report.pdf.all', compact('sales'));
        return $pdf->download('sales_all.pdf');
    }
}
