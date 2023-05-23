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
            $table->tinyInteger('status')->default(0)->after('bike_image')->comment("0 pending,1 accepted,2 rejected");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bike_sell_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
