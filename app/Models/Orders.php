<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetails;
use App\Models\Users;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'id_user',
        'total_harga',
        'alamat',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user', 'id_user');
    }
}
