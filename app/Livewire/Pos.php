<?php
namespace App\Livewire;

use App\Models\Discount;
use Livewire\Component;
use App\Models\Product;
use App\Models\StockInventory;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
class Pos extends Component
{

    use WithPagination;
    public $count = 1;
    public $query = '';
    public $cart = [];
    public $totalPrice = 0;

    public $discounts = [];
    public $discountValue = 0;
    
    public $paymentMethod = 'Cash';
    public $finalPrice = 0;
    public $user;
    public $name = '';
    public $test = '';

    public $customerPhone = '';

    public function mount($user)
    {
        $this->discounts = Discount::where('status', '=', 'active')->get();
        $this->user = $user; 
        $this->updateTotalPrice(); 
        $this->calculateFinalPrice();
        
    }


    public function addOrder($orderItems, $customerPhone='', $discountValue, $totalPrice, $finalPrice, $paymentMethod)
    {
        if (trim($customerPhone) === '') {
            dd("Customer Phone is required");
            return;
        }

        // dd($discountValue);
    
        DB::beginTransaction();
        try {
           
            $order = \App\Models\Order::create([
                'phone' => $customerPhone,
                'discount_id' => $discountValue ? Discount::where('value', $discountValue)->value('id') : null,
                'total_amount' => $totalPrice,
                'final_amount' => $finalPrice,
                'payment_method' => $paymentMethod,
                'status' => 'paid',
            ]);

           
    
          
            foreach ($orderItems as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'stock_inventory_id' => $item['stock_inventory_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['total_price'],
                    'name' => $item['name'],
                    'image' => $item['image'],
                ]);
            }
    
            
            CartItem::where('user_id', $this->user->id)->delete();
    
           
            $this->customerPhone = '';
            $this->discountValue = 0;
            $this->totalPrice = 0;
            $this->finalPrice = 0;
            $this->paymentMethod = 'Cash';
            $this->cart = [];
    
            DB::commit();
    
            redirect( url('/admin/orders'));
        } catch (\Exception $e) {
            DB::rollBack();
           dd($e);
        }
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
            $this->calculateFinalPrice();
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
            $this->updateTotalPrice(); 
            $this->calculateFinalPrice();
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
   
    $this->discountValue = (int) $value;
    $this->calculateFinalPrice();
}

public function calculateFinalPrice()
{
    
    
    $this->finalPrice =$this->totalPrice - $this->totalPrice * ($this->discountValue/100);
}   

public function render()
{
    return view('livewire.pos', [
        'products' => Product::with(['stockInventory.stock'])
            ->where('name', 'like', '%' . $this->query . '%')->orWhere('barcode', 'like', '%' . $this->query . '%')
            ->paginate(10),
            
        'user' => $this->user, 
        'cartItems' => CartItem::where('user_id', '=', $this->user->id)->get(),
        
    ]);
}
}
