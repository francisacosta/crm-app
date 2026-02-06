<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Business::all()->each(function (Business $business): void {
            Company::factory(3)->create(['business_id' => $business->id]);
        });
    }
}
