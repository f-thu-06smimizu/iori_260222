<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insight extends Model
{
    protected $fillable = ['log_id', 'ai_response'];

    // ai_responseカラムを自動で「配列」として扱う設定
    protected $casts = [
        'ai_response' => 'array',
    ];

    // Insightは1つのLogに属する
    public function log(): BelongsTo
    {
        return $this->belongsTo(Log::class);
    }
}