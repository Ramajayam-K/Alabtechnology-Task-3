<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{
    /** @use HasFactory<\Database\Factories\ProductSFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];
    protected $table="products";

    public function orderItems(){
        return $this->hasMany(order_items::class);
    }
}
