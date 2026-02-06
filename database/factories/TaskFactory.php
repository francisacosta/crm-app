<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
            'title' => fake()->sentence(),
            'description' => fake()->text(300),
            'status' => fake()->randomElement(['open', 'in_progress', 'completed', 'cancelled']),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'urgent']),
            'due_date' => fake()->dateTimeBetween('now', '+3 months'),
            'company_id' => Company::factory(),
            'contact_id' => Contact::factory(),
            'deal_id' => Deal::factory(),
            'assigned_to' => User::factory(),
            'created_by' => User::factory(),
        ];
    }
}
