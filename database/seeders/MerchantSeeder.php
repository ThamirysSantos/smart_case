<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Models\MerchantModel;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        MerchantModel::factory(2)->create();
    }
}
