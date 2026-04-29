<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'transaction_id' => null, // set in seeder
            'amount' => $this->faker->numberBetween(1000, 200000),
            'method' => $this->faker->randomElement(['cash','bank_transfer','check']),
            'reference_number' => strtoupper($this->faker->bothify('PAY-#####')),
            'proof_path' => null,
            'status' => $this->faker->randomElement(['pending','confirmed','failed']),
            'confirmed_at' => null,
        ];
    }
}
