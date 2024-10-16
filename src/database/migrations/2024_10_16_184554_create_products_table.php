<?php

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
            $table->text('image');

            $table->decimal('weight', 10, 2);
            $table->decimal('length', 10, 1)->comment('cm unit');
            $table->decimal('width', 10, 1)->comment('cm unit');
            $table->decimal('height', 10, 1)->comment('cm unit');
            $table->decimal('price', 20, 3);
            $table->decimal('amount', 20, 3)->default(0);

            $table->text('country');
            $table->text('importer');

            $table->foreignId('brand_id')
                ->constrained('brands')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('category_id')
                ->constrained('product_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
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
