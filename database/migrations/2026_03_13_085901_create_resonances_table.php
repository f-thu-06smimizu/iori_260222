<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resonances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade'); 
            $table->string('weather');              // 天候
            $table->float('temperature');           // 気温
            $table->float('pressure');              // 気圧
            $table->text('wisdom_text');            // 賢人の言葉
            $table->string('audio_url')->nullable(); 
            $table->string('image_url')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resonances');
    }
};