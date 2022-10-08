<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'parent_id', 'image', 'description',
    ];

    public function news() {
        return $this->hasMany(News::class, 'category_id', 'id');
    }

    public function scopeFilter (Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('categories.name', 'LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('categories.status', '=', $value);
        });
    }

    public static function rules($id = 0) {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
                'filter:laravel,html,php',
            ],
            'image' => [
                'image', 'max:1048576', 'dimensions:min_width=20,min_height=20'
            ],
            'status' => [
                'in:active,archived'
            ]
        ];
    }
}
