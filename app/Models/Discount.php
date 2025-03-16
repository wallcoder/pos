<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Order;
class Discount extends Model
{
    public function order(): HasMany{
        return $this->hasMany(Order::class);
    }
}
