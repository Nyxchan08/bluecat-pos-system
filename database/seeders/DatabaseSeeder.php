<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed fixed genders
        \App\Models\Gender::insert([
            ['gender' => 'Male'],
            ['gender' => 'Female'],
            ['gender' => 'Other'],
        ]);

        // Use factories for other models
        \App\Models\Category::factory(15)->create();
        \App\Models\Supplier::factory(15)->create();
        \App\Models\Product::factory(15)->create();
        \App\Models\User::factory(14)->create(); // Create 14 random users

        // Create an admin user
        $adminUser = User::factory()->create([
            'first_name' => 'Nyx',
            'middle_name' => 'Apruebo',
            'last_name' => 'Moreno',
            'suffix_name' => null,
            'birth_date' => '2011-08-08',
            'gender_id' => 1,  
            'address' => 'Pontevedra, Capiz',
            'contact_number' => '09123456789',
            'email_address' => 'nyx08@gmail.com',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'email_address' => 'user@example.com',
            'username' => 'user',
            'password' => bcrypt('user'),
            'role' => 'user',
        ]);

        // Create transactions for the admin user
        Transaction::factory(15)->forUser($adminUser->user_id)->create();


        // Create transaction items
        \App\Models\TransactionItem::factory(15)->create();
    }
}
