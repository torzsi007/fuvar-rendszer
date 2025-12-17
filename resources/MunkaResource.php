<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MunkaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kiindulo_cim' => $this->kiindulo_cim,
            'erkezesi_cim' => $this->erkezesi_cim,
            'cimzett_nev' => $this->cimzett_nev,
            'cimzett_telefon' => $this->cimzett_telefon,
            'statusz' => $this->statusz,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'fuvarozo' => $this->whenLoaded('fuvarozo', function () {
                return [
                    'id' => $this->fuvarozo->id,
                    'name' => $this->fuvarozo->name,
                    'email' => $this->fuvarozo->email,
                ];
            }),
        ];
    }
}
