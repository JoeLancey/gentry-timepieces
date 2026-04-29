<?php

namespace Database\Seeders;

use App\Models\Watch;
use Illuminate\Database\Seeder;

class WatchSeeder extends Seeder
{
    public function run()
    {
        // create 8 sample watches
        Watch::factory()->count(8)->create();
    }
}
