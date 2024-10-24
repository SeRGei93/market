<?php

namespace Database\Factories;

use Domain\Product\Model\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enum\Status;

/**
 * @extends Factory<ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    protected $model = ProductCategory::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->words(2, true)),
            'description' => $this->faker->sentence,
            'image' => $this->faker->fixturesImage('products', 'products'),
            'status' => $this->faker->randomElement(Status::toArray()),
            'show_in_menu' => $this->faker->randomElement([0, 1, 1, 1]),
            'parent_id' => null,
        ];
    }
}
