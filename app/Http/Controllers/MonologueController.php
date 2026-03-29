<?php

namespace App\Http\Controllers;

use App\Models\Monologue;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MonologueController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // 🌟 管理者なら全投稿（投稿者情報付き）、一般ユーザーなら自分の投稿のみ
        if ($user->is_admin) {
            $monologues = Monologue::with('user')->latest()->get();
        } else {
            $monologues = $user->monologues()->latest()->get();
        }

        return Inertia::render('Dashboard', [
            'monologues' => $monologues,
            // フロント側で「自分は管理者か？」を判別するために追加
            'auth' => [
                'user' => $user,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'body'          => 'required|string',
            'category_id'   => 'required|string',
            'weather_label' => 'nullable|string',
            'temperature'   => 'nullable|numeric',
            'water'         => 'nullable|numeric',
            'act'           => 'nullable|integer',
        ]);

        $request->user()->monologues()->create($validated);

        return redirect()->route('dashboard');
    }

    public function destroy(Monologue $monologue)
    {
        // 🌟 「自分の投稿」または「管理者であること」が削除の条件
        if (auth()->id() === $monologue->user_id || auth()->user()->is_admin) {
            $monologue->delete();
            return redirect()->back();
        }

        abort(403, '削除権限がありません。');
    }
}