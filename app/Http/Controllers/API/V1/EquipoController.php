<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Request;
use Response;
use DB;

use App\Models\V1\Equipo;

class EquipoController extends Controller
{
    /**
     * Obtener lista de Equipos
     * @OA\Get (
     *     path="/api/v1/equipos",
     *     tags={"Equipos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de los equipos y sus niveles",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="200"),
     *              @OA\Property(property="messages",type="string",example="Operación realizada con exito"),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Resuelve FC"),
     *                     @OA\Property(
     *                          type="array",
     *                          property="niveles",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id",type="number",example="1"),
     *                              @OA\Property(property="nivel",type="string",example="A"),
     *                              @OA\Property(property="goles_mes",type="number",example="5"),
     *                              @OA\Property(property="equipos_id",type="int",example="1"),
     *                          )
     *                      )
     *                 )
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
        $data = Equipo::with('niveles')->get();
        $total = $data;

		if(!$data){
			return Response::json(array("status" => 404,"messages" => "No hay resultados"), 200);
		}
		else{
			return Response::json(array("status" => 200,"messages" => "Operación realizada con exito","data" => $data,"total" => count($total)), 200);
		}
    }

    /**
     * Crea un equipo
     * @OA\Post (
     *     path="/api/v1/equipos",
     *     tags={"Equipos"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="nombre",type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "nombre":"Resuelve FC",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Equipo creado",
     *          @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="200"),
     *              @OA\Property(property="messages",type="string",example="Registro creado"),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Resuelve FC"),
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
            $data = new Equipo;
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
     * Actualiza un equipo
     * @OA\Put (
     *     path="/api/v1/equipos/{id}",
     *     tags={"Equipos"},
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
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="nombre",type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "nombre":"Resuelve FC",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Equipo creado",
     *          @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="200"),
     *              @OA\Property(property="messages",type="string",example="Modificación realizada con exito"),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Resuelve FC"),
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
    public function update( $id)
    {
        $this->ValidarParametros(Request::json()->all());
		$datos = (object) Request::json()->all();
		$success = false;

        DB::beginTransaction();
        try{
            $data = Equipo::find($id);

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

        $data->nombre 		= property_exists($datos, "nombre") 	? $datos->nombre 		: $data->nombre;

        if ($data->save()) {
			$success = true;
		}
		return $success;
	}

    /**
     * Detalle del equipo
     * @OA\Get (
     *     path="/api/v1/equipos/{id}",
     *     tags={"Equipos"},
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
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Resuelve FC"),
     *                     @OA\Property(
     *                          type="array",
     *                          property="niveles",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id",type="number",example="1"),
     *                              @OA\Property(property="nivel",type="string",example="A"),
     *                              @OA\Property(property="goles_mes",type="number",example="5"),
     *                              @OA\Property(property="equipos_id",type="int",example="1"),
     *                          )
     *                      )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function show($id)
    {
		$data = Equipo::find($id)->with('niveles')->first();

		if(!$data){
			return Response::json(array("status" => 404,"messages" => "No hay resultados"), 200);
		}
		else{
			return Response::json(array("status" => 200,"messages" => "Operación realizada con exito","data" => $data), 200);
		}
    }

    /**
     * Eliminar Equipo
     * @OA\Delete (
     *     path="/api/v1/equipos/{id}",
     *     tags={"Equipos"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="int")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Eliminar equipo",
     *         @OA\JsonContent(
     *              @OA\Property(property="status",type="int",example="200"),
     *              @OA\Property(property="messages",type="string",example="Registro eliminado"
     *              ),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Resuelve FC"),
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
			$data = Equipo::find($id);
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
			"nombre" => "required|min:3|max:60"
		];
		$v = \Validator::make($request, $rules );

		if ($v->fails()){
			return Response::json($v->errors());
		}
	}
}
