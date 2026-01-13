<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Load all categories with their products
        $categories = Category::with('products')->get();

        // Return view with categories and products
        return view('client.products.index', compact('categories'));
    }

    public function byCategory(Request $request)
    {
        if ($request->category_id === 'all') {
            $categories = Category::with('products')->get();
        } else {
            $categories = Category::with('products')
                ->where('id', $request->category_id)
                ->get();
        }

        return view('client.products._products', compact('categories'))->render();
    }
}
