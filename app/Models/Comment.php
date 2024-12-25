<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $fillable = [
        'artical_id',
        'user_id',
        'content'
    ];

    public function artical(): BelongsTo
    {
        return $this->belongsTo(Artical::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
