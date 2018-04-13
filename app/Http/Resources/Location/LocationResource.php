<?php

namespace App\Http\Resources\Location;

use App\LocationType;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'title' => $this->name,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'image' => new ImageResource($this->whenLoaded('image')),
            'user' => new LocationUser($this->whenLoaded('user')),
            'type' => new LocationTypeResource($this->whenLoaded('type'))
        ];
    }
}
