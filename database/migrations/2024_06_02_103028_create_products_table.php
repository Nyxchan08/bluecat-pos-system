<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id'); 
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->string('sku')->unique();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->unsigned();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->boolean('status')->default(true);
            $table->string('product_image', 255)->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
