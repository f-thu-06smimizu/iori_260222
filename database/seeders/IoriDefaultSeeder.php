<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IoriDefaultSeeder extends Seeder
{
    public function run(): void
    {
        // 1. エリア（旅の舞台）
        $koyaId = DB::table('areas')->insertGetId([
            'name' => '高野山',
            'travel_hub' => '高野山駅'
        ]);

        // 2. 軸（眼差しの定義）
        DB::table('axes')->insert([
            ['id' => 'sage', 'name' => '賢人', 'color_code' => '#4F46E5'],
            ['id' => 'origins', 'name' => '原景', 'color_code' => '#10B981'],
            ['id' => 'healing', 'name' => '湯治', 'color_code' => '#3B82F6'],
            ['id' => 'festival', 'name' => '祭', 'color_code' => '#EF4444'],
        ]);

        // 3. スポット登録：奥之院
        $okunoinId = DB::table('spots')->insertGetId([
            'name' => '高野山 奥之院',
            'name_en' => 'Koyasan Okunoin',
            'latitude' => 34.223000,
            'longitude' => 135.606000,
            'area_id' => $koyaId,
        ]);

        // 4. スポット登録：壇上伽藍
        $garanId = DB::table('spots')->insertGetId([
            'name' => '高野山 壇上伽藍',
            'name_en' => 'Koyasan Danjo Garan',
            'latitude' => 34.214000,
            'longitude' => 135.579000,
            'area_id' => $koyaId,
        ]);

        // 5. 軸とスポットを紐付け（賢人・空海の物語）
        DB::table('axis_spot')->insert([
            [
                'spot_id' => $okunoinId,
                'axis_id' => 'sage',
                'monologue' => '樹齢数百年の杉並木が続くこの道の果てに、空海は今も坐している。すべての人が救われるまで祈りを止めないという一途な意志が、この森に静寂をもたらしている。',
                'yt_context_url' => null, // 慎重に選ぶため空
            ],
            [
                'spot_id' => $garanId,
                'axis_id' => 'sage',
                'monologue' => '鮮やかな朱色の塔は、空海が描いた曼荼羅の宇宙そのものだ。四方に配された仏像と対峙するとき、私たちは己の内側にも同じ広大な宇宙が眠っていることに気づかされる。',
                'yt_context_url' => null,
            ]
        ]);
    }
}