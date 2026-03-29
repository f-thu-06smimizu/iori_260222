<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/spots/{axis_id}', function (Request $request, $axis_id) {
    // spots(場所) と axis_spot(紐付け) を結合
    $query = DB::table('spots')
        ->join('axis_spot', 'spots.id', '=', 'axis_spot.spot_id')
        ->where('axis_spot.axis_id', $axis_id);

    // 賢人が選ばれたなら、その賢人のID（sage_id）で厳密に絞り込む
    if ($axis_id === 'sage' && $request->has('sage_id')) {
        $query->where('axis_spot.sage_id', $request->query('sage_id'));
    }

    $spots = $query->select(
            'spots.id',
            'spots.name', 
            'spots.latitude', 
            'spots.longitude', 
            'axis_spot.monologue', 
            'axis_spot.yt_context_url'
        )->get();

    // Leafletが計算ミスをしないよう、座標を確実に数値型(float)で返す
    return response()->json($spots->map(function ($spot) {
        $spot->latitude = (float) $spot->latitude;
        $spot->longitude = (float) $spot->longitude;
        return $spot;
    }));
});