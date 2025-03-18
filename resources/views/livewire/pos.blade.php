<div class="p-4 flex gap-2 top flex-col xl:flex-row ">
    
    <div class="w-full xl:w-1/2  space-y-1">
       <div class="flex gap-2">
        <input type="search" wire:model.debounce.250ms="query" class="flex-1 p-2 rounded-lg border" placeholder="Search Name or Barcode">
        <button wire:click="" class="px-2 py-2 button w-1/3  font-semibold rounded-lg shadow bg-white">
           Search
        </button>
       </div>
    

    <!-- Debugging Output -->
    {{-- <pre>{{ print_r($products->toArray(), true) }}</pre> --}}
    {{-- <p>Logged-in User ID: {{ $user }}</p> --}}
   {{-- {{ $discounts }} --}}
    <div class="mt-4 list">
        @foreach ($products as $product)
            <div class="product p-2 flex rounded-lg shadow items-center mb-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg">
                
                <div class="flex flex-col p-2 w-full">
                    <span class="font-semibold">{{ $product->name }} ({{ $product->stockInventory->sum('quantity') }})</span>
                    
                    @foreach ($product->stockInventory as $inventory)
                        <div class="flex justify-between items-center  ">
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
</div>
<div class="w-full xl:w-1/2 space-y-2 counter">
{{-- CART GOES HERE --}}
<div class="bg-gray-100 rounded-lg shadow p-2 ">
    <h2 class="text-xl font-semibold mb-4 ">Cart</h2>

    @if(count($cartItems) > 0)
        <div class="space-y-2">
            {{-- <div class="flex justify-between items-center p-2 bg-white rounded-lg shadow">
                <span class="w-1/4"> </span>
                <span class="w-1/4 text-left"> Name </span>
                <span class="w-1/4 text-left">Price</span>
                
                <span class="w-1/4 text-left"> Total</span>
                <div class="w-1/4 flex  space-x-2 gap-1 items-center">
                   
                </div>
            </div> --}}
            @foreach ($cartItems as $item)
                <div class="flex justify-between items-center p-2 bg-white rounded-lg shadow">
                    <span class="w-1/4"><img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-lg"></span>
                    
                    <span class="w-1/4 text-left"> {{ $item->name }}</span>
                    
                    
                    <span class="w-1/4 text-left"> ₹{{ $item->total_price }}</span>
                    <div class="w-1/4 flex  space-x-2 gap-1 items-center">
                        <button wire:click="removeFromCart({{ $item->product_id }}, {{ $item->stock_inventory_id }}, {{$user->id}})" class=" qty-btn px-2 py-1 bg font-semibold rounded-lg shadow hover:bg-blue-600 transition">
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
<div class="bg-gray-100 rounded-lg shadow  p-2 flex flex-col space-y-2">
    <div class="flex flex-col bg-white">
        <div class="flex justify-between p-2"><span>Total Price</span><span>₹{{ $totalPrice }}</span></div>
        <div class="flex justify-between  p-2"><span>Discount</span><span>{{ $discountValue }}%</span></div>
        <div class="flex justify-between  p-2"><span>Final Price</span> <span>₹{{ $finalPrice }}</span></div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <select  wire:model="discountValue" class="p-2 border rounded-lg">
            <option value="0" selected>No Discount</option>
            @if ($discounts->isNotEmpty())
                @foreach ($discounts as $d)
                    <option value="{{ $d->value }}">{{ $d->title }} ({{ $d->value }}%)</option>
                @endforeach
            @endif
        </select>
        <select name="discount" id="discount" class="p-2 border rounded-lg w-20">
        
            <option value="cash" selected >Cash</option>
            <option value="UPI" >UPI</option>
            <option value="Card"  >Card</option>
            
    
           
        </select>
        <input type="number" class=" p-2 rounded-lg border phone" placeholder="Customer Phone">
        <button wire:click="" class="px-2 py-2 button  font-semibold rounded-lg shadow bg-white">
            Confirm 
        </button>
    </div>
    </div>
</div>

<style scoped> 

    .button{
        background: #0E9A6E;
        color: white;
    }

    .button:hover{
        background: #0aaa77;
    }

    .qty-btn{
        background: white;

    }

    .qty-btn:hover{
        background: rgb(235, 235, 235);
    }

    .counter{
        position: sticky;
        
        top: 100px;
    }

    .top{
        
    }

    .list{
       
        max-height: 500px;
        overflow-y:  auto;
    }

    .product{
        background: white;
    }

    .phone{
        width: 200px;
    }

</style>



    
</div>
