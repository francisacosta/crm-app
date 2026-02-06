<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'business_id' => Business::factory(),
            'name' => fake()->catchPhrase(),
            'value' => fake()->randomFloat(2, 5000, 500000),
            'status' => fake()->randomElement(['prospecting', 'qualification', 'negotiation', 'won', 'lost']),
            'expected_close_date' => fake()->dateTimeBetween('now', '+6 months'),
            'company_id' => Company::factory(),
            'contact_id' => Contact::factory(),
            'user_id' => User::factory(),
            'notes' => fake()->text(200),
        ];
    }
}
