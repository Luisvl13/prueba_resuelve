<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Request;
use Response;
use DB;

use App\Models\V1\Nivel;

class NivelController extends Controller
{
    /**
     * Obtener lista de Niveles
     * @OA\Get (
     *     path="/api/v1/niveles",
     *     tags={"Niveles"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de los niveles y sus niveles",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="200"),
     *              @OA\Property(property="messages",type="string",example="Operación realizada con exito"),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(ref="#/components/schemas/Nivel")
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="404"),
     *              @OA\Property(property="error",type="string",example="Mensaje de error"),
     *          )
     *      )
     * )
     */
    public function index()
    {
        $data = Nivel::get();
        $total = $data;

		if(!$data){
			return Response::json(array("status" => 404,"messages" => "No hay resultados"), 200);
		}
		else{
			return Response::json(array("status" => 200,"messages" => "Operación realizada con exito","data" => $data,"total" => count($total)), 200);
		}
    }

    /**
     * Crea un nivel
     * @OA\Post (
     *     path="/api/v1/niveles",
     *     tags={"Niveles"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/Nivel",
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Nivel creado",
     *          @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="200"),
     *              @OA\Property(property="messages",type="string",example="Registro creado"),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     ref="#/components/schemas/Nivel",
     *                 )
     *             )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="400"),
     *              @OA\Property(property="error",type="string",example="Conflicto"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="500"),
     *              @OA\Property(property="error",type="string",example="Mensaje de error"),
     *          )
     *      )
     * )
     */
    public function store()
    {
		$this->ValidarParametros(Request::json()->all());
		$datos = (object) Request::json()->all();
		$success = false;

        DB::beginTransaction();
        try{
            $data = new Nivel;
            $success = $this->campos($datos, $data);

        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(["status" => 500, 'error' => $e->getMessage()." # ".$e->getLine()], 500);
        }
        if ($success){
            DB::commit();
            return Response::json(array("status" => 201,"messages" => "Registro creado","data" => $data), 201);
        }
        else{
            DB::rollback();
            return Response::json(array("status" => 409,"messages" => "Conflicto"), 200);
        }
    }

    /**
     * Actualiza un niveles
     * @OA\Put (
     *     path="/api/v1/niveles/{id}",
     *     tags={"Niveles"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="int")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/Nivel",
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Nivel creado",
     *          @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="200"),
     *              @OA\Property(property="messages",type="string",example="Modificación realizada con exito"),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object", ref="#/components/schemas/Nivel",
     *                 )
     *             )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="500"),
     *              @OA\Property(property="error",type="string",example="Mensaje de error"),
     *          )
     *      )
     * )
     */
    public function update($id)
    {
        $this->ValidarParametros(Request::json()->all());
		$datos = (object) Request::json()->all();
		$success = false;

        DB::beginTransaction();
        try{
            $data = Nivel::find($id);

            if(!$data){
                return Response::json(array("status" => 404, "messages" => "No se encuentra el recurso que esta buscando."), 200);
            }

            $success = $this->campos($datos, $data);

        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(["status" => 500, 'error' => $e->getMessage()." # ".$e->getLine()], 500);
        }
        if($success){
			DB::commit();
			return Response::json(array("status" => 200, "messages" => "Modificación realizada con exito", "data" => $data), 200);
		}
		else {
			DB::rollback();
			return Response::json(array("status" => 304, "messages" => "No modificado"),200);
		}
    }

    public function campos($datos, $data){
		$success = false;

        $data->nivel 		    = property_exists($datos, "nivel") 	? $datos->nivel 		: $data->nivel;
        $data->goles_mes 		= property_exists($datos, "goles_mes") 	? $datos->goles_mes 		: $data->goles_mes;
        $data->equipos_id 	    = property_exists($datos, "equipos_id") 	? $datos->equipos_id 		: $data->equipos_id;

        if ($data->save()) {
			$success = true;
		}
		return $success;
	}

    /**
     * Detalle del nivel
     * @OA\Get (
     *     path="/api/v1/niveles/{id}",
     *     tags={"Niveles"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="int")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación realizada con exito",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="200"),
     *              @OA\Property(property="messages",type="string",example="Operación realizada con exito"),
     *              @OA\Property(property="data", type="array",
     *                  example={"id": 1,"nivel": "A","goles_mes": 5,"equipos_id": 1},
     *                  @OA\Items(type="integer")
     *              )
     *         )
     *     ),
     * )
     */
    public function show($id)
    {
		$data = Nivel::find($id);

		if(!$data){
			return Response::json(array("status" => 404,"messages" => "No hay resultados"), 200);
		}
		else{
			return Response::json(array("status" => 200,"messages" => "Operación realizada con exito","data" => $data), 200);
		}
    }

    /**
     * Eliminar Nivel
     * @OA\Delete (
     *     path="/api/v1/niveles/{id}",
     *     tags={"Niveles"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="int")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Eliminar nivel",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="200"),
     *              @OA\Property(property="messages",type="string",example="Registro eliminado"
     *              ),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object", ref="#/components/schemas/Nivel",
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
		$success = false;
        DB::beginTransaction();
        try {
			$data = Nivel::find($id);
			$data->delete();
			$success = true;
		}
		catch (\Exception $e){
			return Response::json($e->getMessage(), 500);
        }
        if ($success){
			DB::commit();
			return Response::json(array("status" => 200, "messages" => "Registro eliminado", "data" => $data), 200);
		}
		else {
			DB::rollback();
			return Response::json(array("status" => 404, "messages" => "No se encontro el registro"), 404);
		}
    }

    /**
	 * Validad los parametros recibidos, Esto no tiene ruta de acceso es un metodo privado del controlador.
	 *
	 * @param  Request  $request que corresponde a los parametros enviados por el cliente
	 *
	 * @return Response
	 * <code> Respuesta Error json con los errores encontrados </code>
	 */
	private function ValidarParametros($request){
		$rules = [
			"nivel"      => "required|min:3|max:30",
			"goles_mes"  => "required",
			"equipos_id" => "required",
		];
		$v = \Validator::make($request, $rules );

		if ($v->fails()){
			return Response::json($v->errors());
		}
	}
}
