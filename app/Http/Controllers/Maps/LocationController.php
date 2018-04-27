<?php

namespace App\Http\Controllers\Maps;

use App\Http\Requests\Maps\LocationRequest;
use App\Http\Resources\Location\LocationResource;
use App\Image;
use App\Location;
use App\Traits\Controllers\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    use JsonResponseTrait;

    /**
     * @param Location $locations
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection | JsonResponse
     */
    public function index(Location $locations)
    {
        try {
            $locations = $locations->with('type.encyclopedia', 'user', 'image')->get();
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return LocationResource::collection($locations);
    }

    /**
     * creates a new location
     *
     * @param LocationRequest $request
     * @param Image $image
     * @return \Illuminate\Http\JsonResponse
     * @internal param Location $location
     */
    public function store(LocationRequest $request, Image $image)
    {
        $post = $request->all();
        try {
            $path = $request->file('image')->store('public');
            $location = $image->create([
                'path' => $path
            ])->locations()
                ->create([
                    'user_id' => Auth::id(),
                    'location_type_id' => $post['type'],
                    'name' => $post['name'],
                    'description' => $post['description'],
                    'latitude' => $post['latitude'],
                    'longitude' => $post['longitude']
                ]);
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return $this->successResponse('Congratulations, you just added a new location!', 201);
    }
}
