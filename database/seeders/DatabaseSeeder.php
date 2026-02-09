<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $business = Business::factory()
            ->has(User::factory(5))
            ->create([
                'slug' => 'test',
            ]);

        $superAdmin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $users = $business->users;

        $business->users()->attach($superAdmin);

        $companies = Company::factory(100)
            ->for($business)
            ->state(fn () => ['user_id' => $users->random()->id])
            ->create();

        $contacts = Contact::factory(200)
            ->for($business)
            ->recycle($companies)
            ->state(fn () => ['user_id' => $users->random()->id])
            ->create();

        $deals = Deal::factory(100)
            ->for($business)
            ->state(function () use ($contacts, $users) {
                $contact = $contacts->random();

                return [
                    'company_id' => $contact->company_id,
                    'contact_id' => $contact->id,
                    'user_id' => $users->random()->id,
                ];
            })
            ->create();

        $tasks = Task::factory(100)
            ->for($business)
            ->state(function () use ($contacts, $users, $deals) {
                $contact = $contacts->random();

                return [
                    'company_id' => $contact->company_id,
                    'deal_id' => $deals->random()->id,
                    'contact_id' => $contact->id,
                    'assigned_to' => $users->random()->id,
                    'created_by' => $users->random()->id,
                ];
            })
            ->create();
    }
}
