<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Discount;
use App\Models\Customer;
class Order extends Model
{
    public function orderItem(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function discount(): BelongsTo{
        return $this->belongsTo(Discount::class);
    }

    public function customer(): BelongsTo{
        return $this->belongsTo(Customer::class);
    }
}
