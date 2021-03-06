<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Bookable::factory(100)->create();
        \App\Models\Booking::factory(100)->create();
        $this->call(ReviewsTableSeeder::class);
    }
}
