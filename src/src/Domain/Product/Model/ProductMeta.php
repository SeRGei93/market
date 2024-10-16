<?php

namespace Domain\Product\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_key',
        'meta_value',
        'meta_description',
        'product_id',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
