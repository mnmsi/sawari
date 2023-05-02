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
        Schema::create('bike_sell_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('bike_id');
            $table->string('registration_year');
            $table->string('registration_duration');
            $table->string('registration_zone');
            $table->string('registration_series');
            $table->string('color');
            $table->string('mileage_range');
            $table->enum('bought_from_us', ['yes', 'no']);
            $table->string('ownership_status');
            $table->string('engine_condition');
            $table->string('accident_history');
            $table->json('bike_image');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_sell_requests');
    }
};
