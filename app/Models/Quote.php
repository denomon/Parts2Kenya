<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Quote extends Model
{
    protected $fillable = [
        'part_request_id','public_token','status','currency','supplier_cost','service_margin',
        'uk_handling_fee','kenya_shipping_estimate','customs_estimate','expires_at','notes','sent_at','accepted_at'
    ];

    protected function casts(): array
    {
        return [
            'status' => QuoteStatus::class,
            'expires_at' => 'datetime',
            'sent_at' => 'datetime',
            'accepted_at' => 'datetime',
            'supplier_cost' => 'decimal:2',
            'service_margin' => 'decimal:2',
            'uk_handling_fee' => 'decimal:2',
            'kenya_shipping_estimate' => 'decimal:2',
            'customs_estimate' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(fn (Quote $quote) => $quote->public_token ??= Str::uuid()->toString());
    }

    public function partRequest(): BelongsTo { return $this->belongsTo(PartRequest::class); }
    public function items(): HasMany { return $this->hasMany(QuoteItem::class); }
    public function order(): HasMany { return $this->hasMany(Order::class); }

    public function subtotal(): float
    {
        return (float) $this->items()->sum('total_price');
    }

    public function total(): float
    {
        return $this->subtotal()
            + (float) $this->service_margin
            + (float) $this->uk_handling_fee
            + (float) $this->kenya_shipping_estimate
            + (float) $this->customs_estimate;
    }
}
