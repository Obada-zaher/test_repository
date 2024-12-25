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
        'artical_id',
        'image',
    ];

    public function artical(): BelongsTo
    {
        return $this->belongsTo(Artical::class);
    }
}
