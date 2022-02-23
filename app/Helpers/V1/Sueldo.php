<?php

namespace App\Helpers\V1;
use App\Models\V1\Nivel;

class Sueldo{
    public static function sueldo_completo($request)
    {
        foreach ($request['jugadores'] as &$jugador) {
            $bono50 = $jugador['bono']/2;
            $alcance_bono_individual = $jugador['goles'] / Sueldo::obtener_goles_nivel($jugador['nivel']);
            $jugador['goles_minimos'] = Sueldo::obtener_goles_nivel($jugador['nivel']);
            $bono_logrado = $bono50 * ($alcance_bono_individual>=1?1:$alcance_bono_individual) + $bono50 * (Sueldo::porcentaje_alcance_bono_equipo($request)>=1?1:Sueldo::porcentaje_alcance_bono_equipo($request));
            $jugador['sueldo_completo'] = round($jugador['sueldo'] + $bono_logrado, 2);
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
