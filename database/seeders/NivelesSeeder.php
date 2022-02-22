<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('niveles')->insert([
            'nivel' => 'A',
            'goles_mes' => 5,
            'equipos_id' => 1,
            'created_at'=>'2022-02-21 21:50:28',
            'updated_at'=>'2022-02-21 21:50:28',
            'deleted_at'=>NULL
        ]);
        DB::table('niveles')->insert([
            'nivel' => 'B',
            'goles_mes' => 10,
            'equipos_id' => 1,
            'created_at'=>'2022-02-21 21:50:28',
            'updated_at'=>'2022-02-21 21:50:28',
            'deleted_at'=>NULL
        ]);
        DB::table('niveles')->insert([
            'nivel' => 'C',
            'goles_mes' => 15,
            'equipos_id' => 1,
            'created_at'=>'2022-02-21 21:50:28',
            'updated_at'=>'2022-02-21 21:50:28',
            'deleted_at'=>NULL
        ]);
        DB::table('niveles')->insert([
            'nivel' => 'Cuauh',
            'goles_mes' => 20,
            'equipos_id' => 1,
            'created_at'=>'2022-02-21 21:50:28',
            'updated_at'=>'2022-02-21 21:50:28',
            'deleted_at'=>NULL
        ]);
    }
}
