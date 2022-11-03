<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    // protected $guarded = [];

    protected $fillable = [
        'title','slug', 'descriptions', 'category_id', 'image', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')
            ->withDefault();
    }

    public function images()
    {
        return $this->hasMany(NewsImages::class, 'news_id', 'id');
    }

    public function scopeFilter(Builder $builder, $filters) {
        $builder->when($filters['title'] ?? false, function ($builder, $value) {
            $builder->where('news.title', 'LIKE', "%{$value}%");
        });
    }

    public static function rules()
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'image' => ['image'],
            'content_images' => ['image']
        ];
    }
}
