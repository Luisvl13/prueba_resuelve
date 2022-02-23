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
     * Display a listing of the resource.
     *
     * @return Response
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
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
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
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
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
