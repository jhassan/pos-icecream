<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\InvoiceItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    // ✅ PAGE LOAD METHOD (THIS WAS MISSING)
    public function index(Request $request)
    {
        $query = InvoiceItem::with(['product.category', 'invoice.client']);

        // ✅ DEFAULT: Today records
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $fromDate = Carbon::parse($request->from_date)->startOfDay();
            $toDate = Carbon::parse($request->to_date)->endOfDay();

        } else {

            // If no date selected → show today
            $fromDate = Carbon::today()->startOfDay();
            $toDate = Carbon::today()->endOfDay();
        }

        // Apply date filter
        $query->whereHas('invoice', function ($q) use ($fromDate, $toDate) {
            $q->whereBetween('created_at', [$fromDate, $toDate]);
        });

        // ✅ TOTAL using SAME FILTER
        $totalSubtotal = (clone $query)->sum('subtotal');

        // Paginated data
        $reportData = $query->orderByDesc('id')->paginate(20);

        return view('admin.reports.invoice_report', [
            'reportData' => $reportData,
            'categories' => Category::all(),
            'products' => Product::all(),
            'clients' => Client::all(),
            'totalSubtotal' => $totalSubtotal,

            // Pass default dates to view (optional)
            'from_date' => $fromDate->toDateString(),
            'to_date' => $toDate->toDateString(),
        ]);
    }

    public function getData(Request $request)
    {
        $query = InvoiceItem::with(['product.category', 'invoice.client']);

        // Date filter
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    Carbon::parse($request->from_date)->startOfDay(),
                    Carbon::parse($request->to_date)->endOfDay(),
                ]);
            });
        }

        // Product filter
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Client filter
        if ($request->filled('client_id')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('client_id', $request->client_id);
            });
        }

        // ✅ CLONE QUERY FOR TOTAL (IMPORTANT)
        $totalSubtotal = (clone $query)->sum('subtotal');

        // Paginated data
        $reportData = $query->orderByDesc('id')->paginate(20);

        return view('admin.reports.invoice_table', compact('reportData', 'totalSubtotal'))->render();
    }
}
