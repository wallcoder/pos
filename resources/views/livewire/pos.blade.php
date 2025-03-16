<div class="flex gap-4 w-full  p-4">
    <!-- Left Section -->
    <div class="w-full flex flex-col overflow-y-auto p-2 h-[50vh]">
        <div class="flex gap-2">
        <input wire:model.live.debounce.250ms="query" type="search type="text" class="w-full p-2 rounded-lg border " placeholder="Search Name or Barcode">
        <input type="text" class="w-full p-2 rounded-lg border " placeholder="Enter Customer Phone ">
    </div>
        <!-- Product Grid -->
        <div class="flex flex-col gap-2 py-2 overflow-y-auto make-overflow h-[40vh]">
            <div class="flex  gap-2  p-2 rounded-lg shadow">
                <img src="https://media.istockphoto.com/id/185262648/photo/red-apple-with-leaf-isolated-on-white-background.jpg?s=612x612&w=0&k=20&c=gUTvQuVPUxUYX1CEj-N3lW5eRFLlkGrU_cwwwOWxOh8=" alt="Product Image" class="w-32 h-32  rounded-lg">
                
                <div class="flex flex-col w-full">
                    <span class="text-left  font-semibold">Apple(20) {{$products}}</span>
                    <div class="flex justify-between w-full items-center">
                        <span class="w-1/3">First Stock(2)</span>
                        <span class="w-1/3">₹100</span>
                        <button class="w-1/3 ">Select</button>
                    </div>
                    <div class="flex justify-between w-full items-center">
                        <span class="w-1/3">First Stock(2)</span>
                        <span class="w-1/3">₹100</span>
                        <button class="w-1/3 ">Select</button>
                    </div>
                    
                </div>
                
            </div>
           

        </div>
    </div>

    <!-- Right Section -->
    <div class="w-full p-4  rounded-lg shadow sticky top-[10px] ">
       
        <div class="flex  gap-2  p-2 rounded-lg shadow ">
            <img src="https://media.istockphoto.com/id/185262648/photo/red-apple-with-leaf-isolated-on-white-background.jpg?s=612x612&w=0&k=20&c=gUTvQuVPUxUYX1CEj-N3lW5eRFLlkGrU_cwwwOWxOh8=" alt="Product Image" class="w-16 h-16  rounded-lg">
            
            <div class="flex flex-col w-full">
                <div class="w-full flex justify-between">
                    <span class="text-left  font-semibold py-1">Apple</span>
                    <button class="text-sm">X</button>
                </div>
                 <div class="flex justify-between w-full items-center ">
                    
                    <span class="w-1/3">₹100</span>
                    <div class="flex gap-2 items-center">
                        <button class="w-1/3">-</button>
                        <span>2</span>
                    <button class="w-1/3 ">+</button>
                    
                    </div>
                    
                </div>
               
                
            </div>
        </div>
        
        <div class="flex  gap-2  p-2 rounded-lg shadow ">
            <span class="flex justify-between w-full"><span>Total:</span><span>₹200</span> </span>
        </div>
        <button class="py-2 px-3 text-lg font-semibold">Confirm</button>
       
    </div>
</div>
