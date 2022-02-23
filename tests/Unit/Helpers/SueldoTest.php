<?php

namespace Tests\Unit\Controller;

use App\Helpers\V1\Sueldo;
use Tests\TestCase;

class SueldoTest extends TestCase
{
    private $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = [
            "jugadores" => [
                [
                    "nombre" => "Juan Perez",
                    "nivel" => "A",
                    "goles" => 6,
                    "sueldo" => 50000,
                    "bono" => 25000,
                    "sueldo_completo" => null,
                    "equipo" => "rojo"
                ],
                [
                    "nombre" => "Pedro",
                    "nivel" => "B",
                    "goles" => 7,
                    "sueldo" => 100000,
                    "bono" => 30000,
                    "sueldo_completo" => null,
                    "equipo" => "azul"
                ],
                [
                    "nombre" => "Martin",
                    "nivel" => "C",
                    "goles" => 16,
                    "sueldo" => 20000,
                    "bono" => 10000,
                    "sueldo_completo" => null,
                    "equipo" => "azul"
                ],
                [
                    "nombre" => "Luis",
                    "nivel" => "Cuauh",
                    "goles" => 19,
                    "sueldo" => 50000,
                    "bono" => 10000,
                    "sueldo_completo" => null,
                    "equipo" => "rojo"
                ]
            ]
        ];
    }

    public function test_suma_goles_meta_equipo()
    {
        $goles_meta_equipo = Sueldo::suma_goles_meta_equipo($this->request);
        $this->assertEquals(50, $goles_meta_equipo);
    }

    public function test_suma_goles_anotados_equipo()
    {
        $goles_anotados_equipo = Sueldo::suma_goles_anotados_equipo($this->request);
        $this->assertEquals(48, $goles_anotados_equipo);
    }

    public function test_porcentaje_alcance_bono_equipo()
    {
        $alcance_bono_equipo = Sueldo::porcentaje_alcance_bono_equipo($this->request);
        $this->assertEquals(0.96, $alcance_bono_equipo);
    }

    public function test_sueldo_completo()
    {
        $request_sueldo_completo = Sueldo::sueldo_completo($this->request);
        $this->assertEquals(59550, $request_sueldo_completo['jugadores'][3]['sueldo_completo']);
    }
}
