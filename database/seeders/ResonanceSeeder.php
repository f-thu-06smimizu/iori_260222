<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resonance; // モデルが未作成の場合は後ほど作成します

class ResonanceSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('resonances')->insert([
            'sage_id' => 'KUNAGUSI', // 賢人識別子 [cite: 53]
            'title' => '境界の消失', // タイトル [cite: 34]
            'monologue' => "…… 動いている。\nいや、これは『生きている』という言葉ですら、まだ生ぬるい。\nこの追いずり回る黄色い粘液（アメーバ）を見ろ。\nこいつには脳もなければ、心臓もない。\nだが、迷路の最短ルートを知り、餌を求め、時に一つの意志を持って繋がり合う。\n今、私はこの森の湿った土に指を突き立て、彼らと同じ泥を舐めている。\nするとどうだ。\n私の指先から、私という『人間』の境界線がじわじわと溶け出していくのがわかる。\n私は熊楠という個体か？ それとも、この森という巨大な臓器の一部か？", // [cite: 37, 38, 39, 40, 41, 42, 43, 44, 45]
            'audio_url' => 'wet-forest-binaural.mp3', // 没入させる音 [cite: 53]
            'weather' => 'Rain', // 湿度の高い森 [cite: 35]
            'pressure' => 1005.0, // 雨天時を想定
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}