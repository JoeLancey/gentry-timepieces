<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Watch;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $client = Client::first();
        $staff = User::where('role','staff')->first() ?? User::first();
        $watches = Watch::available()->get();

        if ($watches->isEmpty()) {
            // ensure there are some watches
            $watches = Watch::factory()->count(5)->create();
        }

        foreach ($watches as $watch) {
            $transaction = Transaction::factory()->make([
                'watch_id' => $watch->id,
                'client_id' => $client?->id ?? null,
                'staff_id' => $staff->id,
            ]);
            $transaction->save();
            // randomly create a payment partial/full
            if (rand(0,1)) {
                $transaction->payments()->create([
                    'amount' => round($transaction->amount * (rand(50,100) / 100), 2),
                    'method' => 'cash',
                    'reference_number' => 'PAY-' . strtoupper(substr(sha1(time() . rand()), 0, 6)),
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                ]);
            }
        }
    }
}
