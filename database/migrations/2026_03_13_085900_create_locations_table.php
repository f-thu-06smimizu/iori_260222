<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // 土地の名前
            $table->decimal('latitude', 10, 8);      // 緯度
            $table->decimal('longitude', 11, 8);     // 経度
            $table->text('description')->nullable(); // 解説
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};