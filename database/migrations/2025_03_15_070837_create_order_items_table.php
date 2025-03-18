<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_inventory_id')->nullable()->constrained('stock_inventories')->nullOnDelete();
            $table->foreignId('order_id')->constrained('orders');
            $table->integer('quantity');
            $table->decimal('price', 8,2);
            $table->decimal('total_price', 8,2);
            $table->string('name');
            $table->string('image');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
