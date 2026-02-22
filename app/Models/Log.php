<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Log extends Model
{
    // user_id も一括保存できるように追加します
    protected $fillable = ['user_id', 'body', 'location_name', 'image_path'];

    public function insight(): HasOne
    {
        return $this->hasOne(Insight::class);
    }
}