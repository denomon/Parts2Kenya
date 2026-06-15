<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShipmentBatch extends Model
{
    protected $fillable = ['name','month','status','departure_date','arrival_estimate','notes'];

    protected function casts(): array
    {
        return ['month' => 'date', 'departure_date' => 'date', 'arrival_estimate' => 'date'];
    }

    public function orders(): HasMany { return $this->hasMany(Order::class); }
}
