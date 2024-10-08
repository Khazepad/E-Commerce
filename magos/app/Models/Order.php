<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'city',
        'postal_code',
        'shipping_fee',
        'total_amount',
        'payment_method',
        'payment_status',
        'shipping_status',
        'payment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'N/A'
        ]);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
}
