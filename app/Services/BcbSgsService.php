<?php

namespace App\Services;

use App\Http\Resources\ApiBcbResource;
use App\Repositories\Contracts\BcbSgsInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BcbSgsService
{
    private $BcbSgsRepository;

    public function __construct(BcbSgsInterface $BcbSgsRepository)
    {
        $this->BcbSgsRepository = $BcbSgsRepository;
    }

    public function showApiBcbSgs(array $filters){
        if (!array_key_exists('code', $filters) || empty($filters['code'])){
            return  response()->json([
                'status'    => 'error',
                'id'        => 'code',
                'message'   => 'Código não encontrado',
            ], 404);
        }

        $format = '';

        if(array_key_exists('dateStatr', $filters) && array_key_exists('dateEnd', $filters))
            $format = '&dataInicial={'. date('d/m/Y', strtotime($filters['dateStatr'])) .'}&'.'dataFinal={'. date('d/m/Y', strtotime($filters['dateEnd'])) .'}';

        $apiBcb = $this->BcbSgsRepository->showApiBcbSgs($filters['code'], $format);

        if(empty($apiBcb))
            return response()->json([], 204);

        return ApiBcbResource::collection($apiBcb);
    }
}