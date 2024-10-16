<?php

namespace Domain\Product\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = ['image', 'product_id'];

    protected $casts = ['image' => 'array'];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::Class);
    }
}
