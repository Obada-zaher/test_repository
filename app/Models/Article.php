<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    protected $table = "articles";
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'body',
        'status',
        'created_at'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
    
    protected $appends = ['likes_count'];

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }


}

