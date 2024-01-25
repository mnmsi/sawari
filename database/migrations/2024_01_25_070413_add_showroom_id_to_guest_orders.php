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
        Schema::table('guest_orders', function (Blueprint $table) {
            $table->unsignedBigInteger("showroom_id")->unsigned()->nullable();
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guest_orders', function (Blueprint $table) {
            //
        });
    }
};
