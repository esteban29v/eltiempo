<?php

namespace Database\Seeders;

use App\Models\SaleStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SaleStatus::insert([
            ['status_name' => 'pending'],
            ['status_name' => 'done'],
        ]);
    }
}
