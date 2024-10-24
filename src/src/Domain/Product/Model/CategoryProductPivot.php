<?php

declare(strict_types=1);

namespace Domain\Product\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryProductPivot extends Pivot
{
    protected $table = 'product_categorable';
}
