<?php

namespace App\Http\Controllers\Maps;

use App\Http\Resources\Location\LocationTypeResource;
use App\LocationType;
use App\Traits\Controllers\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class LocationTypeController extends Controller
{
    use JsonResponseTrait;

    /**
     * @param LocationType $type
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(LocationType $type)
    {
        try {
            $types = Cache::remember('query.types.all', 1440, function () use ($type){
                return  $type->with('image', 'encyclopedia')->get();
            });
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return LocationTypeResource::collection($types);
    }

    /**
     * @param LocationType $type
     * @return LocationTypeResource
     */
    public function show(LocationType $type)
    {
        $type = $type->load(['image', 'encyclopedia']);
        return new LocationTypeResource($type);
    }
}
