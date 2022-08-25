<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = ['customer_name', 'customer_email', 'shipping', 'invoice_address_title', 'invoice_zip_code', 'invoice_city', 'invoice_address', 'shipping_address_title', 'shipping_zip_code', 'shipping_city', 'shipping_address', 'total'];

    protected $casts =
        [
            'shipping' => \App\Enum\OrderShippingEnum::class,
            'status' => \App\Enum\OrderStatusEnum::class
        ];
}

