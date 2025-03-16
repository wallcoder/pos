<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\StockInventory;
use App\Models\Order;
class OrderItem extends Model
{
    public function stockInventory(): BelongsTo{
        return $this->belongsTo(StockInventory::class);
    }
    public function order(): BelongsTo{
        return $this->belongsTo(Order::class);
    }
}
