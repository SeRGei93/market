<?php

namespace Domain\Product\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Enum\Status;

class ProductCategory extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
        'status',
        'show_in_menu',
        'parent_id'
    ];

    protected $casts = [
        'image' => 'array',
        'status' => Status::class,
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }

    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(CategoryAttribute::class);
    }
}
