<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spot extends Model
{
    // 一つの「土地」は、複数の「レイヤー（物質・現象・残響）」を持つ
    public function layers(): HasMany
    {
        return $this->hasMany(Layer::class);
    }
}