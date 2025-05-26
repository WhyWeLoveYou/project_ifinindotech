<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use App\Models\Users;
use App\Models\Product;

class OrderDetails extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'id_produk',
        'harga',
        'jumlah',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }
}
