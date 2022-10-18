<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiBcbResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'data'  => $this->data,
            'value' => $this->valor
        ];
    }
}