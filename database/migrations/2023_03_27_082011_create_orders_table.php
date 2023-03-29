<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_color_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('delivery_option_id');
            $table->integer('quantity');
            $table->float('price');
            $table->integer('discount_rate');
            $table->integer('shipping_amount');
            $table->float('subtotal_price');
            $table->float('total_price');
            $table->enum('status', ['pending', 'processing', 'completed', 'delivered', 'cancelled']);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable();
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
