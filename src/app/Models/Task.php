<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
