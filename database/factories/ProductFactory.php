<?php

namespace Database\Factories;

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'sku' => $this->faker->unique()->ean13,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->numberBetween(1, 100),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->category_id ?? \App\Models\Category::factory(),
            'supplier_id' => \App\Models\Supplier::inRandomOrder()->first()->supplier_id ?? \App\Models\Supplier::factory(),
            'brand' => $this->faker->word,
            'cost_price' => $this->faker->randomFloat(2, 5, 50),
            'discount' => $this->faker->randomFloat(2, 0, 10),
            'status' => $this->faker->boolean(90),
        ];
    }
}
