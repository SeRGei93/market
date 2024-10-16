<?php

namespace Domain\Product\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Enum\AttributeType;
use Support\Enum\Status;

class CategoryAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'unit',
        'category_id',
    ];

    protected $casts = [
        'status' => Status::class,
        'type' => AttributeType::class,
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function values(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CategoryValue::class);
    }
}
