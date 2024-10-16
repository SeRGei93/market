<?php

namespace Domain\Brand\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Domain\Product\Model\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Enum\Status;

class Brand extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'name',
        'image',
        'slug',
        'status',
        'description',
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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
