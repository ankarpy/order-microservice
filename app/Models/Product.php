<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function orders(){
        return $this->belongsToMany('App\Models\Order', 'App\Models\OrderedProduct', 'product_id', 'order_id')->distinct();
    }
}
