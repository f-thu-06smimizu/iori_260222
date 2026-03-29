<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResonanceSpot; // これを忘れずに追加
use Illuminate\Http\Request;

class ResonanceSpotController extends Controller
{
    /**
     * 指定された軸（originsなど）に紐づくスポット一覧を取得する
     */
    public function index(Request $request)
    {
        // URLの ?axis=xxx を受け取る
        $axisId = $request->query('axis');
        
        // axis_id が一致するものをDBから取得して返す
        return ResonanceSpot::where('axis_id', $axisId)->get();
    }
}