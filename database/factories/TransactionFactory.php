<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['sale','trade_in']);
        $amount = $this->faker->numberBetween(15000, 300000);
        return [
            'watch_id' => null, // set in seeder
            'client_id' => null, // set in seeder
            'staff_id' => null, // set in seeder
            'type' => $type,
            'amount' => $amount,
            'invoice_number' => 'INV-' . strtoupper($this->faker->bothify('??????')),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
