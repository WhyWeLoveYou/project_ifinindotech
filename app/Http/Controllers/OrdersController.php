<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\Users;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{

    public function index()
    {
        $orders = Orders::with(['user', 'details.product'])->paginate(10);
        return view('layouts.order.show', compact('orders'));
    }


    public function create()
    {
        $users = Users::all();
        $products = Product::all();
        return view('layouts.order.add', compact('users', 'products'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_user' => 'required|exists:users,id_user',
                'alamat' => 'required|string|max:255',
                'id_produk' => 'required|array',
                'id_produk.*' => 'required|exists:products,id_produk',
                'harga' => 'required|array',
                'jumlah' => 'required|array',
                'subtotal' => 'required|array',
                'total_harga' => 'required|numeric|min:0',
            ]);

            $order = Orders::create([
                'id_user' => $request->id_user,
                'alamat' => $request->alamat,
                'total_harga' => $request->total_harga,
            ]);

            foreach ($request->id_produk as $i => $id_produk) {
                OrderDetails::create([
                    'order_id' => $order->id,
                    'id_produk' => $id_produk,
                    'harga' => $request->harga[$i],
                    'jumlah' => $request->jumlah[$i],
                    'subtotal' => $request->subtotal[$i],
                ]);
            }

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            Log::error('Order Store Error: '.$e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create order. Please try again.');
        }
    }


    public function edit($id)
    {
        $order = Orders::with('details')->findOrFail($id);
        $users = Users::all();
        $products = Product::all();
        return view('layouts.order.edit', compact('order', 'users', 'products'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'id_user' => 'required|exists:users,id_user',
                'alamat' => 'required|string|max:255',
                'id_produk' => 'required|array',
                'id_produk.*' => 'required|exists:products,id_produk',
                'harga' => 'required|array',
                'jumlah' => 'required|array',
                'subtotal' => 'required|array',
                'total_harga' => 'required|numeric|min:0',
            ]);

            $order = Orders::findOrFail($id);
            $order->update([
                'id_user' => $request->id_user,
                'alamat' => $request->alamat,
                'total_harga' => $request->total_harga,
            ]);

            $order->details()->delete();
            foreach ($request->id_produk as $i => $id_produk) {
                OrderDetails::create([
                    'order_id' => $order->id,
                    'id_produk' => $id_produk,
                    'harga' => $request->harga[$i],
                    'jumlah' => $request->jumlah[$i],
                    'subtotal' => $request->subtotal[$i],
                ]);
            }

            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            Log::error('Order Update Error: '.$e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update order. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $order = Orders::findOrFail($id);
            $order->details()->delete();
            $order->delete();

            return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Order Delete Error: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete order. Please try again.');
        }
    }

    public function print_single_pdf($id)
    {
        try {
            $order = Orders::with(['user', 'details.product'])->findOrFail($id);
            $pdf = Pdf::loadView('layouts.order.pdf', compact('order'));
            return $pdf->download('order_'.$id.'.pdf');
        } catch (\Exception $e) {
            Log::error('Order PDF Error: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate PDF. Please try again.');
        }
    }
}
