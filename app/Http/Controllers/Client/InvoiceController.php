<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Show invoice creation page
     */
    public function createInvoice()
    {
        // Load categories with related products
        $categories = Category::with('products')->get();

        return view('client.invoice.create', compact('categories'));
    }

    /**
     * Store invoice data
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric|min:0',
        ]);

        // Create invoice
        $invoice = Invoice::create([
            'client_id' => auth('client')->id(),
            'total' => $request->total,
        ]);

        // Store invoice items
        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['qty'] * $item['price'],
            ]);
        }

        return response()->json([
            'status' => true,
            'invoice_id' => $invoice->id,
        ]);
    }

    /**
     * Print invoice
     */
    public function print($id)
    {
        $invoice = Invoice::with(['items.product', 'client'])
            ->findOrFail($id);

        return view('client.invoice.print-thermal', compact('invoice'));
    }
}
