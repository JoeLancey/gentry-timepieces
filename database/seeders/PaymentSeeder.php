<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        // Create payments for existing transactions if none exist
        $transactions = Transaction::doesntHave('payments')->get();
        foreach ($transactions as $t) {
            $t->payments()->create([
                'amount' => round($t->amount * (rand(30,100) / 100), 2),
                'method' => ['cash','bank_transfer','check'][array_rand(['cash','bank_transfer','check'])],
                'reference_number' => 'PAY-' . strtoupper(substr(sha1($t->id . time()), 0, 6)),
                'status' => ['pending','confirmed','failed'][array_rand(['pending','confirmed','failed'])],
                'confirmed_at' => now(),
            ]);
        }
    }
}
