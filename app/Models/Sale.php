<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'quote_id',
        'total',
        'payment_type',
        'sale_date',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}