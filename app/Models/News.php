<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // protected $fillable = [
    //     'title', 'descriptions', 'category_id', 'image'
    // ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function scopeFilter(Builder $builder, $filters) {
        $builder->when($filters['title'] ?? false, function ($builder, $value) {
            $builder->where('news.title', 'LIKE', "%{$value}%");
        });
    }
}
