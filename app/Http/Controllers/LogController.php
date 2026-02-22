<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index() {
        // 最新のログを取得して画面に渡す
        $logs = Log::latest()->get();
        return view('logs.index', compact('logs'));
    }
    

    public function store(Request $request) {
        // 入力チェック
        $request->validate(['content' => 'required']);

        // 2/19のDB設計（bodyカラム）に合わせて保存
        Log::create([
            'user_id' => auth()->id() ?? 1,
            'body'    => $request->content, // 画面からのcontentをDBのbodyへ
        ]);

        return back();
    }
}