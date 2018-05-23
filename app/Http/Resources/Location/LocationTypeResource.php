<?php

namespace App\Http\Resources\Location;

use App\Encyclopedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $encyclopedia = $this->whenLoaded('encyclopedia');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start' => $this->season_start,
            'start_format' => $this->season_start->format('F'),
            'end' => $this->season_finish,
            'end_format' => $this->season_finish->format('F'),
            'icon' => $this->icon,
            'image' => $this->whenLoaded('image'),
            'encyclopedia' => $this->when(($encyclopedia instanceof Collection && $encyclopedia->count() > 0),
                function() use ($encyclopedia) {
                    return EncylopediaResource::collection(($encyclopedia));
            })
        ];
    }
}
