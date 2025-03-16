<?php

 
namespace App\Livewire;
 
use Livewire\Component;
use App\Models\Product;
class Pos extends Component
{
    public $count = 1;
    public $query = '';
    public $products = '';
    public function mount()
{
    $this->products = Product::with(['stockInventory.stock'])
        ->where('name', 'like', '%' . $this->query . '%')
        ->limit(10)
        ->get();
}

    public function increment()
    {
        $this->count++;
    }
 
    public function decrement()
    {
        $this->count--;
    }
 
    public function render()
    {
        return view('livewire.pos');
    }
}