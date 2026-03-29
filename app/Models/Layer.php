<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Layer extends Model
{
    // レイヤーは必ずどこか一つの「土地」に属する
    public function spot(): BelongsTo
    {
        return $this->belongsTo(Spot::class);
    }
}