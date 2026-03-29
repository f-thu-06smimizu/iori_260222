<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResonanceSpot;

class ResonanceSpotSeeder extends Seeder
{
  public function run(): void
{
    // --- 原景 (origins) ---
    ResonanceSpot::create([
        'axis_id' => 'origins',
        'name' => '那智の滝',
        'latitude' => 33.6751, 
        'longitude' => 135.8879,
        'title' => '第一の徴',
        'monologue' => '水は高いところから低いところへ流れる。...',
        'sage_id' => 'KUNAGUSI',
    ]);

    ResonanceSpot::create([
        'axis_id' => 'origins',
        'name' => '高野山 奥之院',
        'latitude' => 34.2230, 
        'longitude' => 135.6063,
        'title' => '入定の地',
        'monologue' => '杉の巨木が空を隠し、苔が音を吸い込む。ここは時間の終着駅だ。',
        'sage_id' => 'KUKAI',
    ]);

    // --- 祭 (festival) ---
    ResonanceSpot::create([
        'axis_id' => 'festival',
        'name' => '那智の火祭',
        'latitude' => 33.6687, 
        'longitude' => 135.8911,
        'title' => '炎の浄化',
        'monologue' => '大きな松明が参道を焼き尽くすように進む。熱気が肌を刺す。',
        'sage_id' => 'TRADITION',
    ]);
}
}