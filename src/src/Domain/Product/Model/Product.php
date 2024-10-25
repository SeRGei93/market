<?php

namespace Domain\Product\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Database\Factories\ProductFactory;
use Domain\Brand\Model\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_categorable')
            ->using(CategoryProductPivot::class);
    }

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function meta(): HasOne
    {
        return $this->hasOne(ProductMeta::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(CategoryValue::class);
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
