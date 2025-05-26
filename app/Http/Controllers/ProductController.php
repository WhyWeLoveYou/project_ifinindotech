<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


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
        request()->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
        ]);

        Product::create(request()->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    public function edit(Product $product, string $id) : View
    {
        $product = Product::findOrFail($id);
        return view('layouts.product.edit', compact('product'));
    }
    

    public function update(Product $product, $id) : RedirectResponse
    {
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
    }

    public function destroy(Product $product, $id) : RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
    
}