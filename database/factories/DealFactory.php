<?php

namespace Database\Factories;

use App\Enums\DealStatus;
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
        $company = Company::factory();

        return [
            'business_id' => Business::factory(),
            'name' => fake()->catchPhrase(),
            'value' => fake()->randomFloat(2, 5000, 500000),
            'status' => fake()->randomElement(DealStatus::values()),
            'expected_close_date' => fake()->dateTimeBetween('now', '+6 months'),
            'company_id' => $company,
            'contact_id' => Contact::factory()->for($company),
            'user_id' => User::factory(),
            'notes' => fake()->text(200),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
