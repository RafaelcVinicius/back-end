<?php

namespace App\Http\Controllers;

use App\Classes\CustomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\BcbSgsService;
use App\Repositories\Contracts\BcbSgsInterface;
use stdClass;

class ConsultaDadosController extends Controller
{
    public function __construct(BcbSgsService $BcbSgsService)
    {
        $this->BcbSgsService = $BcbSgsService;
    }

    public function consultaDados(Request $request)
    {
        $obj = new stdClass;
        $obj = json_decode($request->obj);
        // $dias = floor((strtotime( $obj->dataFinal) - strtotime($obj->dataInicial)) / (60 * 60 * 24));
        $valor = [];

        $formato = 'dados?formato=json&dataInicial={'. date('d/m/Y', strtotime($obj->dataInicial)) .'}&'.'dataFinal={'. date('d/m/Y', strtotime($obj->dataFinal)) .'}';
        $codConsulta =  433;

        $req = new CustomRequest;
        $req->setRoute(config('routes-api.bcb.sgs').$codConsulta.'/'.$formato);
        $req->setHeaders([
            'Host'          =>  'api.bcb.gov.br',
            'User-Agent'    =>  'null',
            'Accept'        =>  '*/*',
        ]);
        $req->get();
        
        $dadosBcb = $req->response->asJson;
        $valorInicial = $obj->valorInicial;
        foreach ($dadosBcb as $key => $value) {
            $valorInicial += round(($valorInicial*($value->valor/100)), 2, PHP_ROUND_HALF_EVEN);
            array_push($valor,  ['valor' => round($valorInicial, 2, PHP_ROUND_HALF_EVEN), 'data' => $value->data]);
        }

        return $this->BcbSgsService->teste();
    }
}
