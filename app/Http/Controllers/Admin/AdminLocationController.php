<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Location\LocationResource;
use App\Location;
use App\Traits\Controllers\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AdminLocationController extends Controller
{
    use JsonResponseTrait;
    /**
     * @param Location $locations
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection | JsonResponse
     */
    public function index(Location $locations)
    {
        try {
            $locations= Cache::remember('query.locations.admin.all', 1440, function () use ($locations){
                return $locations
                    ->with('type.encyclopedia', 'type.image', 'user', 'image', 'feedback.user')
                    ->get();
            });
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return LocationResource::collection($locations);
    }

    /**
     * deletes a record
     *
     * @param Location $location
     * @return JsonResponse
     */
    public function destroy(Location $location)
    {
        try {
            $location->delete();
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }
        return response()->json([
            'success' =>  'A location has been deleted!'
        ]);
    }
}
