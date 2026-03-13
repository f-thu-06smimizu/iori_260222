<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function check(Request $request)
    {
        $userLat = $request->lat;
        $userLng = $request->lng;

        // 1. 天気APIからデータを取得
        $apiKey = env('OPENWEATHER_API_KEY');
        $weatherResponse = Http::get("https://api.openweathermap.org/data/2.5/weather?lat={$userLat}&lon={$userLng}&appid={$apiKey}&units=metric&lang=ja");
        $weatherData = $weatherResponse->json();

        // 2. DBから「高野山」のデータを取得
        $target = DB::table('locations')->where('name', '高野山')->first();

        if (!$target) {
            return response()->json(['error' => '聖地が見つかりません']);
        }

        // 3. 距離計算（Haversine formula）
        $earthRadius = 6371; 
        $dLat = deg2rad($target->latitude - $userLat);
        $dLon = deg2rad($target->longitude - $userLng);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($userLat)) * cos(deg2rad($target->latitude)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        // 4. 気圧による状態判定
        $pressure = $weatherData['main']['pressure'] ?? 1013;
        $atmosphere = '標準的な大気';

        if ($pressure < 1000) {
            $atmosphere = '低気圧（残響の予感）';
        } elseif ($pressure > 1020) {
            $atmosphere = '高気圧（静寂の刻）';
        }

        // 5. すべてのデータをまとめて返す
        return response()->json([
            'name' => $target->name,
            'distance' => round($distance, 2),
            'weather' => $weatherData['weather'][0]['description'] ?? '不明',
            'pressure' => $pressure,
            'atmosphere' => $atmosphere,
            'temp' => $weatherData['main']['temp'] ?? '---',
        ]);
    }
}