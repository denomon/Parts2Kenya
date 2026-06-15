<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PartRequest extends Model
{
    protected $fillable = [
        'customer_id','vehicle_make','vehicle_model','vehicle_year','registration_number','vin',
        'part_name','part_description','urgency','photo_path','status','admin_notes'
    ];

    protected function casts(): array
    {
        return ['status' => OrderStatus::class];
    }

    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function quotes(): HasMany { return $this->hasMany(Quote::class); }
    public function order()
    {
        return $this->hasOneThrough(
            Order::class,
            Quote::class,
            'part_request_id',
            'quote_id',
            'id',
            'id'
        );
    }


    public function quote(): HasOne
    {
        return $this->hasOne(Quote::class);
    }


}
