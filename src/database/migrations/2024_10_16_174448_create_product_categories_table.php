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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->enum('status', Status::toArray())->default(Status::draft->value);
            $table->string('name');
            $table->text('description');
            $table->string('slug')->unique()->nullable();
            $table->text('image')->nullable();
            $table->boolean('show_in_menu')->default(true);
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('product_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('sort')->default(500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
