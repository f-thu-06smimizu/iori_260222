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
        // 1. エリアマスタ
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('travel_hub')->nullable();
        });

        // 2. 軸（眼差し）マスタ
        Schema::create('axes', function (Blueprint $table) {
            $table->string('id')->primary(); // sage, festival, healing, origins
            $table->string('name');
            $table->string('color_code')->nullable();
        });

        // 3. スポット基本情報
        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->foreignId('area_id')->constrained(); // areas.id と紐付け
            $table->string('ig_tag_url')->nullable();
            $table->string('fb_official_url')->nullable();
            $table->timestamps();
        });

        // 4. 軸別ストーリー（中間テーブル）
        Schema::create('axis_spot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spot_id')->constrained()->onDelete('cascade');
            $table->string('axis_id');
            $table->foreign('axis_id')->references('id')->on('axes')->onDelete('cascade');
            $table->text('monologue'); // 独白
            $table->string('yt_context_url')->nullable(); // YouTube
            $table->string('hero_image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('axis_spot');
        Schema::dropIfExists('spots');
        Schema::dropIfExists('axes');
        Schema::dropIfExists('areas');
    }
};