<?php

namespace Domain\Product\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category_attribute_id',
        'value',
    ];

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CategoryAttribute::class, 'category_attribute_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
