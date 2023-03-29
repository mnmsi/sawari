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
        Schema::table('sell_bikes', function (Blueprint $table) {
            $table->foreign('brand_id')
                  ->references('id')
                  ->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sell_bikes', function (Blueprint $table) {
            $table->dropForeign('bike_sell_requests_brand_id_foreign');
        });
    }
};
