<div class="p-4 flex gap-2 top flex-col xl:flex-row ">
    @livewireStyles
    @livewireScripts
    <div class="w-full xl:w-1/2  space-y-1">
       <div class="flex gap-2">
       
        <input type="search" wire:model="query" class="flex-1 p-2 rounded-lg border" placeholder="Search Name or Barcode">
       
       </div>
       {{-- Hi! My name is <span wire:poll.500ms>{{ $name }}</span>

       <span wire:poll.500ms>{{ $customerPhone}}</span>
       <span wire:poll.500ms>{{ $discountValue}}</span>
       <span wire:poll.500ms>{{ $paymentMethod}}</span> --}}
    
    <div class="mt-4 list">
        @foreach ($products as $product)
            <div class="product p-2 flex rounded-lg shadow items-center mb-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img w-16 h-16 object-cover rounded-lg">
                
                <div class="flex flex-col p-2 w-full">
                    <span class="font-semibold">{{ $product->name }} ({{ $product->stockInventory->sum('quantity') }}) <span class="text-xs font-semibold">barcode:  {{ $product->barcode }} </span></span>
                    
                    @foreach ($product->stockInventory as $inventory)
                        <div class="flex justify-between items-center">
                            <span>{{ $inventory->stock->name }} ({{ $inventory->quantity }})</span>
                            <span>₹{{ $inventory->price }}</span>
                            <button wire:click="addToCart({{ $product->id }}, {{ $inventory->id }}, {{$user->id}})" class="qty-btn px-2 py-1 bg font-semibold rounded-lg shadow hover:bg-blue-600 transition">
                                +
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

 
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

<div class="w-full xl:w-1/2 space-y-2 counter">
    <div class="bg-gray-100 rounded-lg shadow p-2">
        <h2 class="text-xl font-semibold mb-4">Cart</h2>

        @if(count($cartItems) > 0)
            <div class="space-y-2">
                @foreach ($cartItems as $item)
                    <div class="flex justify-between items-center p-2 bg-white rounded-lg shadow">
                        <span class="w-1/4 flex gap-2 items-center">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img w-16 h-16 object-cover rounded-lg">
                            <span class="w-1/4 text-left">{{ $item->name }}</span>
                        </span>
                        <span class="w-1/4 text-left"> ₹{{ $item->total_price }}</span>
                        <div class="w-1/4 flex space-x-2 gap-1 items-center">
                            <button wire:click="removeFromCart({{ $item->product_id }}, {{ $item->stock_inventory_id }}, {{$user->id}})" class="qty-btn px-2 py-1 bg font-semibold rounded-lg shadow hover:bg-blue-600 transition">
                                -
                            </button>
                            <span class="text-xs min-w-10"> {{ $item->quantity }}</span>
                            <button wire:click="addToCart({{ $item->product_id }}, {{ $item->stock_inventory_id }}, {{$user->id}})" class="qty-btn px-2 py-1 bg font-semibold rounded-lg shadow hover:bg-blue-600 transition">
                                +
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Cart is empty.</p>
        @endif
    </div>

    <div class="bg-gray-100 rounded-lg shadow p-2 flex flex-col space-y-2">
        <div class="flex flex-col bg-white">
            <div class="flex justify-between p-2"><span>Total Price</span><span>₹{{ $totalPrice }}</span></div>
            <div class="flex justify-between p-2"><span>Discount</span><span wire:poll.500ms>{{ $discountValue }}%</span></div>
            <div class="flex justify-between p-2"><span>Final Price</span> <span wire:poll.500ms>₹{{ $finalPrice }}</span></div>
        </div>
        <div class="flex gap-2 flex-wrap">
            <select wire:model="discountValue" class="p-2 border rounded-lg">
                <option value="0">No Discount</option>
                @if ($discounts->isNotEmpty())
                    @foreach ($discounts as $d)
                        <option value="{{(int) $d->value }}">{{ $d->title }} ({{ $d->value }}%)</option>
                    @endforeach
                @endif
            </select>
            <select name="discount" id="discount" class="p-2 border rounded-lg w-20" wire:model="paymentMethod" wire:poll.500ms>
                <option value="Cash" selected>Cash</option>
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
            </select>
            <input type="number" class="p-2 rounded-lg border phone" placeholder="Customer Phone" wire:model="customerPhone" wire:poll.500ms>
            <button wire:click="addOrder({{ $cartItems }}, '{{ $customerPhone }}', {{ $discountValue }}, {{ $totalPrice }}, {{ $finalPrice }}, '{{ $paymentMethod }}')" class="px-2 py-2 button font-semibold rounded-lg shadow bg-white">
                Confirm
            </button>
        </div>
    </div>
</div>

<style scoped> 
.img {
    width: 60px;
    height: 60px;
}
.button {
    background: #0E9A6E;
    color: white;
}
.button:hover {
    background: #0aaa77;
}
.qty-btn {
    background: white;
}
.qty-btn:hover {
    background: rgb(235, 235, 235);
}
.counter {
    position: sticky;
    top: 100px;
}
.list {
    max-height: 500px;
    overflow-y: auto;
}
.product {
    background: white;
}
.phone {
    width: 200px;
}
</style>
</div>
