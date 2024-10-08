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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->decimal('total_amount', 8, 2);
            $table->decimal('shipping_fee', 8, 2)->default(0.00); // Add this line
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('shipping_status', ['pending', 'shipped', 'delivered'])->default('pending');
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
