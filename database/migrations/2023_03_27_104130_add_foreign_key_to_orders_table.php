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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('product_color_id')
                ->references('id')
                ->on('product_colors');

            $table->foreign('delivery_option_id')
                  ->references('id')
                  ->on('delivery_options');

            $table->foreign('payment_method_id')
                    ->references('id')
                    ->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_user_id_foreign');
            $table->dropForeign('orders_product_id_foreign');
            $table->dropForeign('orders_product_color_id_foreign');
            $table->dropForeign('orders_delivery_option_id_foreign');
            $table->dropForeign('orders_payment_method_id_foreign');
        });
    }
};
