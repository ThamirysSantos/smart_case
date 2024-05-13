<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Models\PaymentMethodModel;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethodModel::factory(3)->create();
    }
}
