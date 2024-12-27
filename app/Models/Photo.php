<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;
    protected $table = "photos";
    protected $fillable = [
        'article_id',
        'image',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
