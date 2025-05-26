<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_user',
        'nama_user',
        'alamat',
    ];
}
