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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_id')->nullable()->constrained('discounts');
            $table->string('phone');
            $table->decimal('total_amount', 8,2);
            $table->decimal('final_amount', 8,2);
            $table->string('payment_method');
            $table->enum('status', ['pending', 'cancelled', 'paid'])->default('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
