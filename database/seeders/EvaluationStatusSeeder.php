<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('evaluation_status')->insert([
            'eval_status' => 'close',
            'eval_status_p2p' => 'close',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
