<?php

namespace Domain\Product\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Domain\Brand\Model\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Enum\Status;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'name',
        'preview',
        'description',
        'slug',
        'image',
        'status',
        'tags',
        'weight',
        'length',
        'height',
        'width',
        'price',
        'amount',
        'brand_id',
        'category_id',
        'country',
        'importer',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function metas(): HasMany
    {
        return $this->hasMany(ProductMeta::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(CategoryValue::class);
    }
}
