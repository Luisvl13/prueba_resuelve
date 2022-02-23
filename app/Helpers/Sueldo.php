<?php

namespace App\Helpers;
use App\Models\V1\Nivel;

class Sueldo{
    public static function sueldo_completo($request)
    {
        $request_bono_logrado = Sueldo::bono_logrado($request);
        foreach ($request_bono_logrado['jugadores'] as &$jugador) {
            $jugador['sueldo_completo'] = $jugador['sueldo'] + $jugador['bono_logrado'];
        }

        return $request_bono_logrado;
    }

    public static function bono_logrado($request)
    {
        $request_alcance_bono_individual = Sueldo::porcentaje_alcance_bono_individual($request);
        foreach ($request_alcance_bono_individual['jugadores'] as &$jugador) {
            $bono50 = $jugador['bono']/2;
            $jugador['bono_logrado'] = ($bono50 * $jugador['alcance_bono_individual']) + ($bono50 * Sueldo::porcentaje_alcance_bono_equipo($request_alcance_bono_individual));
        }

        return $request_alcance_bono_individual;
    }

    public static function porcentaje_alcance_bono_individual($request)
    {
        foreach ($request['jugadores'] as &$jugador) {
            $jugador['alcance_bono_individual'] = $jugador['goles'] / Sueldo::obtener_goles_nivel($jugador['nivel']);
        }

        return $request;
    }

    public static function porcentaje_alcance_bono_equipo($request)
    {
        $listaJugadores = array_filter($request['jugadores'], function($v){return $v !== null;});

        $suma_goles_anotados = Sueldo::suma_goles_anotados_equipo($request);
        $suma_goles_meta= Sueldo::suma_goles_meta_equipo($request);

        $alcance_bono_equipo =  $suma_goles_anotados / $suma_goles_meta;
        return $alcance_bono_equipo;
    }

    public static function suma_goles_anotados_equipo($request)
    {
        $listaJugadores = array_filter($request['jugadores'], function($v){return $v !== null;});

        $suma = 0;
        foreach ($listaJugadores as $jugador) {
            $suma += $jugador['goles'];
        }

        return $suma;
    }

    public static function suma_goles_meta_equipo($request)
    {
        $listaJugadores = array_filter($request['jugadores'], function($v){return $v !== null;});

        $suma = 0;
        foreach ($listaJugadores as $jugador) {
            $suma += Sueldo::obtener_goles_nivel($jugador['nivel']);
        }

        return $suma;
    }

    public static function obtener_goles_nivel($nivel){
        $res_nivel = Nivel::where('nivel', $nivel)->first();
        return $res_nivel->goles_mes;
    }
}
