<?php

namespace Domain\Product\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Database\Factories\ProductCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'parent_id',
        'sort'
    ];

    protected $casts = [
        'image' => 'array',
        'status' => Status::class,
        'sort' => 'int'
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

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categorable', 'product_id')
            ->using(CategoryProductPivot::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    protected static function newFactory(): ProductCategoryFactory
    {
        return ProductCategoryFactory::new();
    }
}
