<?php

namespace Database\Seeders;

use App\Models\BiddingHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BiddingHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BiddingHistory::factory(20)->create();
    }
}
