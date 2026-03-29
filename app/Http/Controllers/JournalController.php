<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JournalController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');
        $apiKey = config('services.gemini.key');

        if (!$apiKey) {
            return response()->json(['reply' => 'APIキーが設定されていません。']);
        }

        // モデル名の指定を、最も確実な形式に変更しました
        // gemini-1.5-flash -> models/gemini-1.5-flash
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => "あなたはIORIです。短く返答してください。\n\n" . $userMessage]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            // ここでエラーが出る場合は、URLそのものが現在のAPIキーで許可されていない可能性があります
            return response()->json(['reply' => '通信エラー(' . $response->status() . '): ' . $response->body()]);
        }

        $aiText = $response->json('candidates.0.content.parts.0.text') ?? '...';

        return response()->json(['reply' => $aiText]);
    }
}