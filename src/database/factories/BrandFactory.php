<?php

namespace Database\Factories;

use Domain\Brand\Model\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enum\Status;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'image' => $this->faker->fixturesImage('brands', 'brands'),
            'status' => $this->faker->randomElement(Status::toArray()),
            'description' => $this->faker->sentence,
            'sort' => $this->faker->randomElement([100, 200, 300, 400, 500]),
        ];
    }
}
