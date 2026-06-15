<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'whatsapp', 'kenya_delivery_location'];

    public function partRequests(): HasMany { return $this->hasMany(PartRequest::class); }
    public function orders(): HasMany { return $this->hasMany(Order::class); }
}
