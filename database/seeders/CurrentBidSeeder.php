<?php

namespace Database\Seeders;

use App\Models\CurrentBid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrentBidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CurrentBid::factory(20)->create();
    }
}
