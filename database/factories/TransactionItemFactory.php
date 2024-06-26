<?php

namespace Database\Factories;

use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionItemFactory extends Factory
{
    protected $model = TransactionItem::class;

    public function definition()
    {
        return [
            'transaction_id' => \App\Models\Transaction::inRandomOrder()->first()->transaction_id ?? \App\Models\Transaction::factory(),
            'product_id' => \App\Models\Product::inRandomOrder()->first()->product_id ?? \App\Models\Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'cost_price' => $this->faker->randomFloat(2, 5, 50),
        ];
    }
}
