<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->lastName,
            'last_name' => $this->faker->lastName,
            'suffix_name' => $this->faker->optional()->suffix,
            'birth_date' => $this->faker->date(),
            'gender_id' => \App\Models\Gender::inRandomOrder()->first()->gender_id,
            'address' => $this->faker->address,
            'contact_number' => $this->faker->phoneNumber,
            'email_address' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'), 
            
        ];
    }
}
