<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Business::all()->each(function (Business $business): void {
            Task::factory(10)->create([
                'business_id' => $business->id,
                'company_id' => Company::where('business_id', $business->id)->inRandomOrder()->first()?->id,
                'contact_id' => Contact::where('business_id', $business->id)->inRandomOrder()->first()?->id,
                'deal_id' => Deal::where('business_id', $business->id)->inRandomOrder()->first()?->id,
            ]);
        });
    }
}
