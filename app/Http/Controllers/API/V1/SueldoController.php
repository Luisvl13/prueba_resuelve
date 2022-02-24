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
     *             @OA\JsonContent(
     *              @OA\Property(
     *                 type="array",
     *                 property="jugadores",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="nombre",type="string",example="Luis"),
     *                     @OA\Property(property="nivel",type="string",example="Cuauh"),
     *                     @OA\Property(property="goles",type="int",example="21"),
     *                     @OA\Property(property="sueldo",type="int",example="50000"),
     *                     @OA\Property(property="bono",type="int",example="10000"),
     *                     @OA\Property(property="sueldo_completo",type="null",example="null"),
     *                     @OA\Property(property="equipo",type="string",example="rojo"),
     *                 )
     *             )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Agrega Sueldo completos de los jugadores",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                 type="array",
     *                 property="jugadores",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="nombre",type="string",example="Luis"),
     *                     @OA\Property(property="nivel",type="string",example="Cuauh"),
     *                     @OA\Property(property="goles",type="int",example="21"),
     *                     @OA\Property(property="sueldo",type="int",example="50000"),
     *                     @OA\Property(property="bono",type="int",example="10000"),
     *                     @OA\Property(property="sueldo_completo",type="int",example="59550"),
     *                     @OA\Property(property="equipo",type="string",example="rojo"),
     *                 )
     *             )
     *          )
     *      ),
     * )
     */
    public function sueldo_completo()
    {
		$datos = Request::json()->all();
        $data = Sueldo::sueldo_completo($datos);

        return Response::json(array("status" => 200,"messages" => "Operación realizada con exito","data" => $data), 200);
    }
}
