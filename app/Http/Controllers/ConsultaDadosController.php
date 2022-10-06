<?php

namespace App\Http\Controllers;

use App\Classes\CustomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;

class ConsultaDadosController extends Controller
{
    public function consultaDados(Request $request)
    {
        $obj = new stdClass;
        $obj = json_decode($request->obj);

        $formato = 'dados?formato=json&dataInicial={'. $obj->dataInicial .'}&'.'dataFinal={'. $obj->dataFinal .'}';
        $codConsulta =  433;
Log::info(  $formato);
        $req = new CustomRequest;
        $req->setRoute(config('routes-api.bcb.sgs').$codConsulta.'/'.$formato);
        $req->setHeaders([
            'Host'          =>  'api.bcb.gov.br',
            'User-Agent'    =>  'null',
            'Accept'        =>  '*/*',
        ]);
        $req->get();

        return $req->response->asJson;
    }
}
