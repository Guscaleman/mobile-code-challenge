<?php

namespace App\Models;

use App\Constants\Table;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = Table::ORDERS;

    protected $casts = [
        'order_date'   => 'date:Y-m-d',
        'delivered_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'customer_name',
        'order_date',
        'delivered_at',
        'status'
    ];
}
