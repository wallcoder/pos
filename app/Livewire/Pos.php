<?php
namespace App\Livewire;

use App\Models\Discount;
use Livewire\Component;
use App\Models\Product;
use App\Models\StockInventory;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Pos extends Component
{
    public $count = 1;
    public $query = '';
    public $cart = [];
    public $totalPrice = 0;

    public $discounts = [];
    public $discountValue = 0;
    
    public $finalPrice = 0;
    public $user;

    public function mount($user)
    {
        $this->discounts = Discount::where('status', '=', 'active')->get();
        $this->user = $user; // Assign userId passed from Filament
        $this->updateTotalPrice(); // Set total price on component mount
    }

    public function addToCart($productId, $inventoryId, $userId)
    {
        $product = Product::find($productId);
        $inventory = StockInventory::find($inventoryId);

        if (!$product || !$inventory) {
            dd("Product or Inventory not found", $product, $inventory);
        }

        DB::beginTransaction();
        try {
            $cartItem = CartItem::where('stock_inventory_id', $inventoryId)
                ->where('user_id', $userId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += 1;
                $cartItem->total_price = $cartItem->quantity * $cartItem->price;
                $cartItem->save();
            } else {
                CartItem::create([
                    'stock_inventory_id' => $inventory->id,
                    'image' => $product->image,
                    'name' => $product->name,
                    'product_id' => $productId,
                    'quantity' => 1,
                    'price' => $inventory->price,
                    'total_price' => $inventory->price * 1,
                    'user_id' => $userId
                ]);
            }

            if ($inventory->quantity > 0) {
                $inventory->quantity -= 1;
                $inventory->save();
            } else {
                throw new \Exception("Insufficient stock for this item.");
            }

            DB::commit();
            $this->updateTotalPrice(); // Update total price after adding item
        } catch (\Exception $e) {
            DB::rollBack();
            dd("Error adding to cart: " . $e->getMessage());
        }
    }

    public function removeFromCart($productId, $inventoryId, $userId)
    {
        $product = Product::find($productId);
        $inventory = StockInventory::find($inventoryId);

        if (!$product || !$inventory) {
            dd("Product or Inventory not found", $product, $inventory);
        }

        DB::beginTransaction();
        try {
            $cartItem = CartItem::where('stock_inventory_id', $inventoryId)
                ->where('user_id', $userId)
                ->first();

            if ($cartItem) {
                if ($cartItem->quantity > 1) {
                    $cartItem->quantity -= 1;
                    $cartItem->total_price = $cartItem->quantity * $cartItem->price;
                    $cartItem->save();
                } else {
                    $cartItem->delete();
                }

                $inventory->quantity += 1;
                $inventory->save();
            } else {
                throw new \Exception("Item not found in cart.");
            }

            DB::commit();
            $this->updateTotalPrice(); // Update total price after removing item
        } catch (\Exception $e) {
            DB::rollBack();
            dd("Error removing from cart: " . $e->getMessage());
        }
    }

    public function updateTotalPrice()
    {
        $this->totalPrice = CartItem::where('user_id', $this->user->id)->sum('total_price');
    }


    public function updatedDiscountValue($value)
{
    Log::info('Updated Discount Value: ' . $value);
    $this->discountValue = (int) $value;
    $this->calculateFinalPrice();
}

public function calculateFinalPrice()
{
    $discountAmount = ($this->totalPrice * $this->discountValue) / 100;
    $this->finalPrice = $this->totalPrice - $discountAmount;
}

public function render()
{
    return view('livewire.pos', [
        'products' => Product::with(['stockInventory.stock'])
            ->where('name', 'like', '%' . $this->query . '%')
            ->limit(10)
            ->get(),
        'user' => $this->user,
        'cartItems' => CartItem::where('user_id', '=', $this->user->id)->get(),
        // Default to total price if not set
    ]);
}
}
