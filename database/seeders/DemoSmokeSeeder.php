<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Watch;
use App\Models\Appraisal;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DemoSmokeSeeder extends Seeder
{
    public function run()
    {
        $staff = User::where('role', 'staff')->first();
        $checker = User::where('role', 'checker')->first();

        $client = Client::firstOrCreate(
            ['email' => 'demo.client@example.local'],
            ['first_name' => 'Demo', 'last_name' => 'Client', 'phone' => '000-000-0000']
        );

        $watch = Watch::firstOrCreate([
            'serial_number' => 'DEMO-001'
        ],[
            'brand' => 'Omega',
            'model' => 'Speedmaster',
            'reference_number' => null,
            'serial_number' => 'DEMO-001',
            'year_produced' => null,
            'condition' => 'good',
            'has_box' => false,
            'has_papers' => false,
            'asking_price' => 0.00,
            'cost_price' => 0.00,
            'status' => 'reserved',
            'image_path' => null,
            'description' => 'Demo watch for smoke tests',
        ]);

        $appraisal = Appraisal::firstOrCreate([
            'client_id' => $client->id,
            'watch_id' => $watch->id,
        ],[
            'appraiser_id' => $staff?->id,
            'appraised_value' => 0.00,
            'condition_notes' => '',
            'workflow_status' => defined('App\\Models\\Appraisal::STATUS_PENDING') ? Appraisal::STATUS_PENDING : 'pending',
        ]);

        Log::info('DemoSmokeSeeder created: client='.$client->id.' watch='.$watch->id.' appraisal='.$appraisal->id);
    }
}
