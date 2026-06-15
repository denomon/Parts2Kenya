<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\Payment;

class Order extends Model
{
    protected $fillable = ['customer_id','quote_id','order_number','status','total_amount','currency','shipment_batch_id'];

    protected function casts(): array
    {
        return ['status' => OrderStatus::class, 'total_amount' => 'decimal:2'];
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->order_number ??= 'BP-' . now()->format('Ym') . '-' . strtoupper(Str::random(6));
        });
    }

    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function quote(): BelongsTo { return $this->belongsTo(Quote::class); }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
    public function shipmentBatch(): BelongsTo { return $this->belongsTo(ShipmentBatch::class); }
    public function trackingEvents(): HasMany { return $this->hasMany(ShipmentTrackingEvent::class)->latest(); }
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
