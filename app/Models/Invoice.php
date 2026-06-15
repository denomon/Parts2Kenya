<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


use Illuminate\Support\Str;

class Invoice extends Model
{
    protected $fillable = ['order_id','invoice_number','amount','currency','issued_at','pdf_path'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'issued_at' => 'datetime'];
    }

    protected static function booted(): void
    {
        static::creating(fn (Invoice $invoice) => $invoice->invoice_number ??= 'INV-' . now()->format('Ym') . '-' . strtoupper(Str::random(5)));
    }

    public function order(): BelongsTo { return $this->belongsTo(Order::class); }

}
