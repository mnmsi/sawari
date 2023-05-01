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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('bike_id')->nullable();
            $table->integer('registration_year')->nullable();
            $table->integer('registration_duration')->nullable();
            $table->string('registration_zone')->nullable();
            $table->string('registration_series')->nullable();
            $table->string('color')->nullable();
            $table->string('mileage_range');
            $table->enum('bought_from_us', ['yes', 'no'])->nullable();
            $table->string('ownership_status')->nullable();
            $table->string('engine_condition')->nullable();
            $table->string('accident_history')->nullable();
            $table->string('bike_image')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable();
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
