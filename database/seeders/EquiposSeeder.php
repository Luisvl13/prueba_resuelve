<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equipos')->insert([
            'nombre' => 'Resuelve FC',
            'created_at'=>'2022-02-21 21:50:28',
            'updated_at'=>'2022-02-21 21:50:28',
            'deleted_at'=>NULL
        ]);
        DB::table('equipos')->insert([
            'nombre' => 'Tuxtla FC',
            'created_at'=>'2022-02-21 21:50:28',
            'updated_at'=>'2022-02-21 21:50:28',
            'deleted_at'=>NULL
        ]);
    }
}
