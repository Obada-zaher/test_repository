<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;
    protected $table = "likes";
    protected $fillable = [
        'artical_id',
        'user_id',
        'liked'
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
