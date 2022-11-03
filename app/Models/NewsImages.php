<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NewsImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id', 'news_images'
    ];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->news_images);
    }
}
