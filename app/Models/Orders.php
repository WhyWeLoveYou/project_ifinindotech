<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'id_user',
        'id_produk',
        'harga',
        'jumlah',
        'total_harga',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
