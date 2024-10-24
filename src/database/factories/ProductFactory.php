<?php

namespace Database\Factories;

use Domain\Brand\Model\Brand;
use Domain\Product\Model\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use MoonShine\Tests\Fixtures\Models\Category;
use Support\Enum\Status;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->words(3, true)),
            'preview' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'image' => $this->faker->fixturesImage('products', 'products'),
            'status' => $this->faker->randomElement(Status::toArray()),
            'weight' => $this->faker->randomFloat(2, 0, 1000),
            'length' => $this->faker->randomFloat(1, 0, 1000),
            'height' => $this->faker->randomFloat(1, 0, 1000),
            'width' => $this->faker->randomFloat(1, 0, 1000),
            'price'=> $this->faker->numberBetween(10000, 1000000),
            'amount' => $this->faker->numberBetween(0, 20),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'country' => $this->faker->country,
            'importer' => $this->faker->company,
        ];
    }
}
