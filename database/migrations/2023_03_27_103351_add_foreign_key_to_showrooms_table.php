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
        Schema::table('showrooms', function (Blueprint $table) {
            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries');

            $table->foreign('division_id')
                  ->references('id')
                  ->on('divisions');

            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities');

            $table->foreign('area_id')
                  ->references('id')
                  ->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('showrooms', function (Blueprint $table) {
            $table->dropForeign('showrooms_country_id_foreign');
            $table->dropForeign('showrooms_division_id_foreign');
            $table->dropForeign('showrooms_city_id_foreign');
            $table->dropForeign('showrooms_area_id_foreign');
        });
    }
};
