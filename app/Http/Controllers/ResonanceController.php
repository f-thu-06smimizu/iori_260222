<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // DB操作を使えるように追加
use Inertia\Inertia;

class ResonanceController extends Controller
{
    /**
     * $id を受け取れるようにします。
     * URLが /resonance/show/2 なら岡本太郎(ID:2)を表示します。
     */
    public function show($id = 1)
    {
        // データベースの spots テーブルと axis_spot テーブルをくっつけて
        // 指定された ID のデータ（名前、緯度経度、独白など）を取得します
        $resonance = DB::table('axis_spot')
            ->join('spots', 'axis_spot.spot_id', '=', 'spots.id')
            ->where('spots.id', $id)
            ->where('axis_spot.axis_id', 'sage') // 賢人（sage）軸のデータに限定
            ->first();

        // もし ID に対応するデータがない場合は、安全策として1番（空海）を表示
        if (!$resonance) {
            $resonance = DB::table('axis_spot')
                ->join('spots', 'axis_spot.spot_id', '=', 'spots.id')
                ->where('spots.id', 1)
                ->first();
        }

        // 既存の Show.vue 画面に、取得したデータを渡します
        // 変数名 'resonance' は変えないので、画面の配置は崩れません
        return Inertia::render('Resonance/Show', [
            'resonance' => $resonance
        ]);
    }
}