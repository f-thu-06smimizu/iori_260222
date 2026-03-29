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
        Schema::table('monologues', function (Blueprint $table) {
            $table->float('water')->default(0); // 水分量 (L)
            $table->integer('act')->default(0);  // 運動量 (歩数など)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monologues', function (Blueprint $table) {
            $table->dropColumn(['water', 'act']);
        });
    }
};