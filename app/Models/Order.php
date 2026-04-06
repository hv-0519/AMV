<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'guest_name', 'guest_email', 'guest_phone',
        'order_type', 'status', 'total_amount', 'tax_amount',
        'delivery_address', 'notes', 'payment_method', 'payment_status',
        'transaction_id', 'upi_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    public function shouldRedirectToPaymentAfterCheckout(): bool
    {
        return in_array($this->payment_method, ['upi', 'card', 'online'], true)
            && $this->payment_status !== 'paid';
    }

    public function canProceedToPayment(): bool
    {
        return $this->payment_status !== 'paid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCustomerNameAttribute(): string
    {
        return $this->user?->name ?? $this->guest_name ?? 'Guest';
    }
}
