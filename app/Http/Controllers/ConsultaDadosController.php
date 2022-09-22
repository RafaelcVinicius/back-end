<?php

namespace App\Http\Controllers;

use App\Classes\CustomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsultaDadosController extends Controller
{
    public function consultaDados()
    {
        $formato = 'dados?formato=json&dataInicial={01/01/2022}&dataFinal={01/05/2022}';
        $codConsulta = 433;

        $req = new CustomRequest;
        $req->setRoute(config('routes-api.bcb.sgs').$codConsulta.'/'.$formato);
        $req->setHeaders([
            'Content-Type'                  => 'application/json',
            // 'ETag'                          => 'W/"ba-O7G7lwH60RMWC+U5CH0wAw"',
            // 'Access-Control-Allow-Origin'   => '*',
            // 'Date'                          => 'Thu, 22 Sep 2022 01:13:14 GMT',
            // 'Content-Length'                => '186',
            // 'Strict-Transport-Security'     => 'max-age=16070400; includeSubDomains',
            // 'Set-Cookie'                    => 'TS01799025=0198c2d644ae0f81fa072582816bde66a4c925831dbdd808a6dad338b464cd152219c9d18c6e3855d86d2b8fa0c4a73994b154ec48; Path=/',
            // 'Authorization'                 => 'bearer 63|bOQcJXkWrPACuGUKUeZxGCw6gkGebgA2yjgSahZb',
            // 'Accept'                        => 'application/json',
        ]);
        
        $req->get();
        dd($req);
    }
}
