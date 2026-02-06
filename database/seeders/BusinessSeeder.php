<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testUser = User::where('email', 'test@example.com')->first();

        if ($testUser) {
            $business = Business::create([
                'name' => 'Test Business',
                'slug' => 'test-business',
                'description' => 'A test business for development',
            ]);

            $business->users()->attach($testUser);
        }

        Business::factory(5)->create()->each(function ($business) {
            $business->users()->attach(
                User::inRandomOrder()->limit(rand(1, 2))->pluck('id')
            );
        });
    }
}
