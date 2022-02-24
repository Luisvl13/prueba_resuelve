<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Request;
use Response;

use App\Helpers\V1\Sueldo;

class SueldoController extends Controller
{
    /**
     * Genera Sueldos
     * @OA\Post (
     *     path="/api/v1/sueldos",
     *     tags={"Sueldos"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *              @OA\Property(
     *                 type="array",
     *                 property="equipos",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Resuelve FC"),
     *                     @OA\Property(
     *                          type="array",
     *                          property="jugadores",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="nombre",type="string",example="Luis"),
     *                              @OA\Property(property="nivel",type="string",example="Cuauh"),
     *                              @OA\Property(property="goles",type="int",example="21"),
     *                              @OA\Property(property="sueldo",type="int",example="50000"),
     *                              @OA\Property(property="bono",type="int",example="10000"),
     *                              @OA\Property(property="sueldo_completo",type="null",example="null"),
     *                              @OA\Property(property="equipo",type="string",example="rojo"),
     *                          )
     *                      )
     *                 )
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Agrega Sueldo completos de los jugadores",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                 type="array",
     *                 property="equipos",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Resuelve FC"),
     *                     @OA\Property(
     *                          type="array",
     *                          property="jugadores",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="nombre",type="string",example="Luis"),
     *                              @OA\Property(property="nivel",type="string",example="Cuauh"),
     *                              @OA\Property(property="goles",type="int",example="21"),
     *                              @OA\Property(property="sueldo",type="int",example="50000"),
     *                              @OA\Property(property="bono",type="int",example="10000"),
     *                              @OA\Property(property="sueldo_completo",type="int",example="59550"),
     *                              @OA\Property(property="equipo",type="string",example="rojo"),
     *                          )
     *                      )
     *                 )
     *             )
     *         )
     *      ),
     * )
     */
    public function sueldo_completo()
    {
		$datos = Request::json()->all();
        $equipos_id = 1;

        if(isset($datos['equipos'])){
            foreach ($datos['equipos'] as &$equipo) {
                $equipos_id = $equipo['id'];
                $equipo= Sueldo::sueldo_completo($equipo, $equipos_id);
            }
        }else{
            $datos = Sueldo::sueldo_completo($datos, $equipos_id);
        }

        return $datos;
    }
}
