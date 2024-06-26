<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_name' => fake()->company(50),
            'contact_person' => fake()->name(50),
            'supplier_address' => fake()->address(50),
            'supplier_phone' => fake()->phoneNumber(50),
            'supplier_email' => fake()->safeEmail(50),
        ];
    }
}
