<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Domain\Brand\Model\Brand;
use Domain\Product\Model\Product;
use Domain\Product\Model\ProductCategory;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Brand::factory(50)->create();

        // level 1
        ProductCategory::factory(5)
            ->create()
            ->each(function (ProductCategory $category) {
                // level 2
                ProductCategory::factory(5)
                    ->create([
                        'parent_id' => $category->id
                    ])
                    ->each(function (ProductCategory $category2) {
                        // level 3
                        ProductCategory::factory(10)
                            ->create([
                                'parent_id' => $category2->id
                            ]);

                        Product::factory(10)
                            ->create()
                            ->each(function (Product $product) use ($category2) {
                                $product->categories()->attach($category2->id);
                            });
                    });
            });
    }
}
