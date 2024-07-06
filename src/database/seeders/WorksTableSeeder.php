<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Seeder;


class WorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Work::factory()->count(30)->create();
    }
}
