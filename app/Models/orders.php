<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];
    protected $table="orders";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(order_items::class, 'orders_id');
    }
    
}
