<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Request;
use Response;

use App\Helpers\V1\Sueldo;

class SueldoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function sueldo_completo()
    {
		$datos = Request::json()->all();
        $data = Sueldo::sueldo_completo($datos);

        return Response::json(array("status" => 200,"messages" => "Operación realizada con exito","data" => $data), 200);
    }
}
