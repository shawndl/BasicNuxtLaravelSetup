<?php

namespace App\Http\Resources\Location;

use App\Encyclopedia;
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
        $image = $this->whenLoaded('image');
        $encyclopedia = $this->whenLoaded('encyclopedia');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start' => $this->season_start,
            'start_format' => $this->season_start->format('jS M'),
            'end' => $this->season_finish,
            'end_format' => $this->season_finish->format('jS M'),
            'icon' => $this->icon,
            'image' => $this->when(isset($image->id), function() use ($image) {
                return $image->path;
            }),
            'encyclopedia' => $this->when(($encyclopedia instanceof Encyclopedia && $encyclopedia->count() > 0),
                function() use ($encyclopedia) {
                    return EncylopediaResource::collection(($encyclopedia));
            })
        ];
    }
}
