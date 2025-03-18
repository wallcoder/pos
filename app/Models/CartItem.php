<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    public function stockInventory(): BelongsTo{
        return $this->belongsTo(StockInventory::class);
    }
}
