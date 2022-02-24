<?php

namespace App\Helpers\V1;
use App\Models\V1\Nivel;

class Sueldo{
    public static function sueldo_completo($request, $equipos_id)
    {
        foreach ($request['jugadores'] as &$jugador) {
            $bono50 = $jugador['bono']/2;
            $alcance_bono_individual = $jugador['goles'] / Sueldo::obtener_goles_nivel($jugador['nivel'], $equipos_id);
            $jugador['goles_minimos'] = Sueldo::obtener_goles_nivel($jugador['nivel'], $equipos_id);
            $bono_logrado = $bono50 * ($alcance_bono_individual>=1?1:$alcance_bono_individual) + $bono50 * (Sueldo::porcentaje_alcance_bono_equipo($request, $equipos_id)>=1?1:Sueldo::porcentaje_alcance_bono_equipo($request, $equipos_id));
            $jugador['sueldo_completo'] = round($jugador['sueldo'] + $bono_logrado, 2);
        }

        return $request;
    }

    public static function porcentaje_alcance_bono_equipo($request, $equipos_id)
    {
        $suma_goles_anotados = Sueldo::suma_goles_anotados_equipo($request);
        $suma_goles_meta= Sueldo::suma_goles_meta_equipo($request, $equipos_id);

        $alcance_bono_equipo =  $suma_goles_anotados / $suma_goles_meta;
        return $alcance_bono_equipo;
    }

    public static function suma_goles_anotados_equipo($request)
    {
        $suma = 0;
        foreach ($request['jugadores'] as $jugador) {
            $suma += $jugador['goles'];
        }

        return $suma;
    }

    public static function suma_goles_meta_equipo($request, $equipos_id)
    {
        $suma = 0;
        foreach ($request['jugadores'] as $jugador) {
            $suma += Sueldo::obtener_goles_nivel($jugador['nivel'], $equipos_id);
        }

        return $suma;
    }

    public static function obtener_goles_nivel($nivel, $equipos_id){
        $res_nivel = Nivel::where('nivel', $nivel)->where('equipos_id', $equipos_id)->first();
        return $res_nivel['goles_mes'];
    }
}
