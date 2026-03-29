<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // 忘れずに追加

class Monologue extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'category_id',
        'weather_label',
        'temperature',
        'water',
        'act',
    ];

    /**
     * 🌟 これがないと Controller の with('user') でエラーになります
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}