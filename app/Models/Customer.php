<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Order;

class Customer extends Model
{
    public function customer(): HasMany{
        return $this->hasMany(Order::class);
    }
}
