<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\StockInventory;
class Product extends Model
{
    public function stockInventory(): HasMany{
        return $this->hasMany(StockInventory::class);
    }
}
