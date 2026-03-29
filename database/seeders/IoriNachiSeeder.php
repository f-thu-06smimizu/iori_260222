<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IoriNachiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. スポット（那智の原生林）を登録
        $spotId = DB::table('spots')->insertGetId([
            'name' => '那智の原生林',
            'latitude' => 33.675000,
            'longitude' => 135.885000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. 三層レイヤーのデータを投入
        DB::table('layers')->insert([
            [
                'spot_id' => $spotId,
                'type' => 'material',
                'title' => '物質：数千年の沈黙',
                'content' => '巨石、巨木、古道、湯治場。数千年の沈黙。',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'spot_id' => $spotId,
                'type' => 'phenomena',
                'title' => '現象：今この瞬間の鼓動',
                'content' => '祭祀、神事、風の音、光の角度。今この瞬間の鼓動。',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'spot_id' => $spotId,
                'type' => 'resonance',
                'title' => '残響：南方熊楠「境界の消失」',
                'content' => '「……動いている。いや、これは『生きている』という言葉ですら、まだ生ぬるい。この這いずり回る黄色い粘液（アメーバ）を見ろ。……私という『人間』の境界線がじわじわと溶け出していくのがわかる。」',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}