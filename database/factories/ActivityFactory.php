<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
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
            'type' => fake()->randomElement(['call', 'email', 'meeting', 'note']),
            'content' => fake()->text(300),
            'activity_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'company_id' => Company::factory(),
            'contact_id' => Contact::factory(),
            'deal_id' => Deal::factory(),
            'user_id' => User::factory(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
