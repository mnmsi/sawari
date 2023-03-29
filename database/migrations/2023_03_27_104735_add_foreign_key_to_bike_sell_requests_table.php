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
        Schema::table('bike_sell_requests', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('city_id')
                    ->references('id')
                    ->on('cities');

            $table->foreign('area_id')
                    ->references('id')
                    ->on('areas');

            $table->foreign('brand_id')
                    ->references('id')
                    ->on('brands');

            $table->foreign('bike_id')
                ->references('id')
                ->on('sell_bikes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bike_sell_requests', function (Blueprint $table) {
            $table->dropForeign('bike_sell_requests_user_id_foreign');
            $table->dropForeign('bike_sell_requests_city_id_foreign');
            $table->dropForeign('bike_sell_requests_area_id_foreign');
            $table->dropForeign('bike_sell_requests_brand_id_foreign');
            $table->dropForeign('bike_sell_requests_bike_id_foreign');
        });
    }
};
