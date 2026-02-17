<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $fillable = [
        'date',
        'user_noted_id',
        'content',
        'user_id',
        'aproved',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
