<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{

    public function index() : View
    {
        $products = Product::latest()->paginate(10);

        return view('layouts.product.show', compact('products'));
    }

    public function create() : View
    {
        return view('layouts.product.add');
    }

    public function store() : RedirectResponse
    {
        try {
            request()->validate([
                'nama_produk' => 'required',
                'harga' => 'required|numeric',
            ]);

            Product::create(request()->all());

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Product Store Error: '.$e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create product. Please try again.');
        }
    }


    public function edit(Product $product, $id) : View
    {
        $product = Product::findOrFail($id);
        return view('layouts.product.edit', compact('product'));
    }
    

    public function update(Product $product, $id) : RedirectResponse
    {
        try {
            $product = Product::findOrFail($id);

            request()->validate([
                'nama_produk' => 'required',
                'harga' => 'required|numeric',
            ]);

            $product->update([
                'nama_produk' => request('nama_produk'),
                'harga' => request('harga'),
            ]);


            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Product Update Error: '.$e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy(Product $product, $id) : RedirectResponse
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Product Delete Error: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete product. Please try again.');
        }
    }
    
}