<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceReportController extends Controller
{
    public function index(Request $request)
    {
        $clientId = Auth::guard('client')->id();

        // 🔒 Scope to logged-in client
        $query = Invoice::with(['items.product'])
            ->where('client_id', $clientId);

        /** 📅 Date filter */
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay(),
            ]);
        }

        /** 📦 Product filter */
        if ($request->filled('product_id')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        /** 💰 Min / Max total */
        if ($request->filled('min_total')) {
            $query->where('total', '>=', $request->min_total);
        }

        if ($request->filled('max_total')) {
            $query->where('total', '<=', $request->max_total);
        }

        /** 🔢 Invoice ID */
        if ($request->filled('invoice_id')) {
            $query->where('id', $request->invoice_id);
        }

        /** 📊 Totals */
        $totalSales = (clone $query)->sum('total');

        $totalQty = (clone $query)->withSum('items as total_qty', 'qty')
            ->get()
            ->sum('total_qty');

        /** 📄 Pagination */
        $invoices = $query->latest()
            ->paginate(30)
            ->withQueryString();

        // ✅ Fetch categories for navbar
        $categories = Category::all();

        return view('client.reports.invoice_report', compact(
            'invoices',
            'totalSales',
            'totalQty',
            'categories'
        ));
    }

    /** 🧾 View / Print Invoice */
    public function show($id)
    {
        $invoice = Invoice::with(['items.product'])
            ->where('client_id', Auth::guard('client')->id())
            ->findOrFail($id);

        // ✅ Fetch categories for navbar
        $categories = Category::all();

        return view('client.invoice.show', compact('invoice', 'categories'));
    }

    /** 🧾 View / Return Invoice */
    public function returnProducts($id)
    {
        $invoice = Invoice::with(['items.product'])
            ->where('client_id', Auth::guard('client')->id())
            ->findOrFail($id);

        // ✅ Fetch categories for navbar
        $categories = Category::all();

        return view('client.invoice.return', compact('invoice', 'categories'));
    }
}
