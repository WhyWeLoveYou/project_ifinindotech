<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Users;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Orders::with(['user', 'product'])->paginate(10); // NOT ->get()
        return view('layouts.order.show', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = Users::all();
        $products = Product::all();

        return view('layouts.order.add', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_produk' => 'required|exists:products,id_produk',
            'harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'alamat' => 'required|string|max:255',
        ]);

        Orders::create($request->all());

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function print_to_pdf()
    {
        $orders = Orders::with(['user', 'product'])->get();
        $pdf = Pdf::loadView('layouts.order.pdf', compact('orders'));
        return $pdf->download('orders.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Orders::findOrFail($id);
        $users = Users::all();
        $products = Product::all();

        return view('layouts.order.edit', compact('order', 'users', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_produk' => 'required|exists:products,id_produk',
            'harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'alamat' => 'required|string|max:255',
        ]);

        $order = Orders::findOrFail($id);
        $order->update($request->all());

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
