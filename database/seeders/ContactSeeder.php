<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Business::all()->each(function (Business $business): void {
            Contact::factory(5)->create([
                'business_id' => $business->id,
                'company_id' => Company::where('business_id', $business->id)->inRandomOrder()->first()?->id,
            ]);
        });
    }
}
