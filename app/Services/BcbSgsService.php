<?php

namespace App\Services;

use App\Repositories\Contracts\BcbSgsInterface;
use Illuminate\Http\Request;

class BcbSgsService
{
    private $BcbSgsRepository;

    public function __construct(BcbSgsInterface $BcbSgsRepository)
    {
        $this->BcbSgsRepository = $BcbSgsRepository;
    }

    public function teste(){
        return $this->BcbSgsRepository->teste();
    }
}