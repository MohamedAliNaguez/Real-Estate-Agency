<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'address' => $this->address,
            'size' => $this->size,
            'bedrooms' => $this->bedrooms,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'price' => $this->price,
        ];
    }
}
