<?php

namespace App\Repositories;

use App\Classes\CustomRequest;
use App\Repositories\Contracts\BcbSgsInterface;

class BcbSgsRepository implements BcbSgsInterface
{
    public function showApiBcbSgs($code, $format = ''){
        $req = new CustomRequest;
        $req->setRoute(config('routes-api.bcb.sgs').$code.'/dados?formato=json/'.$format);
        $req->setHeaders([
            'Host'          =>  'api.bcb.gov.br',
            'User-Agent'    =>  'null',
            'Accept'        =>  '*/*',
        ]);
        $req->get();

        if(($req->get()) && ($req->response->code == 200))
            return $req->response->asJson;
        else{
            return [
                'status'   => 'error',
                'message'  => 'Ocorreu um erro na api no bcb',
                'code'     =>  $req->response->code
            ];
        }
    }
}