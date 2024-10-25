<?php

use Domain\Product\Model\Product;
use Domain\Product\Model\ProductCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Support\Enum\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('status', Status::toArray())->default(Status::draft->value);
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->text('preview');
            $table->text('description');
            $table->text('image')->nullable();
            $table->text('instructions')->nullable();

            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('length', 10, 1)->nullable()->comment('cm unit');
            $table->decimal('width', 10, 1)->nullable()->comment('cm unit');
            $table->decimal('height', 10, 1)->nullable()->comment('cm unit');
            $table->decimal('price', 20, 3);
            $table->decimal('amount', 20, 3)->default(0);

            $table->text('country');
            $table->text('importer');

            $table->foreignId('brand_id')
                ->constrained('brands')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('sort')->default(500);
            $table->timestamps();
        });

        Schema::create('product_categorable', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(ProductCategory::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
