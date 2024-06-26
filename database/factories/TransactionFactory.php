<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->user_id ?? \App\Models\User::factory(),
            'total_amount' => $this->faker->randomFloat(2, 50, 500),
            'transaction_date' => $this->faker->dateTime(),
            'discount' => $this->faker->randomFloat(2, 0, 10),
            'payment_amount' => $this->faker->randomFloat(2, 50, 500),
            'change' => $this->faker->randomFloat(2, 0, 50),
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card', 'paypal']),
        ];
    }

    public function forUser($userId)
    {
        return $this->state([
            'user_id' => $userId,
        ]);
    }
}
