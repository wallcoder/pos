<?php

namespace App\Models;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrderItem;
use App\Casts\MoneyCast;
class StockInventory extends Model
{

    protected $casts = [
        'price' => MoneyCast::class,
    ];
    public function stock(): BelongsTo{
        return $this->belongsTo(Stock::class);
    }
    
    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function orderItems(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function cartItem(): HasMany{
        return $this->hasMany(CartItem::class);
    }
}
