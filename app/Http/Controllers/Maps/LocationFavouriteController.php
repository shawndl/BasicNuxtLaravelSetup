<?php

namespace App\Http\Controllers\Maps;

use App\Favourite;
use App\Http\Requests\Maps\LocationFavouriteRequest;
use App\Http\Resources\Location\LocationFavouriteResource;
use App\Location;
use App\Traits\Controllers\JsonResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationFavouriteController extends Controller
{
    use JsonResponseTrait;

    /**
     * gets all the users favourites
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try {
            $favourites = auth()->user()->favourites;
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return LocationFavouriteResource::collection($favourites);
    }

    /**
     * Toggles if a location is favourite
     *
     * @param LocationFavouriteRequest $request
     * @param Location $location
     * @return LocationFavouriteResource|\Illuminate\Http\JsonResponse
     */
    public function store(LocationFavouriteRequest $request, Location $location)
    {
        try {
            $location = $location->findOrFail($request->location);
            $favourite = $location->addFavourite(auth()->user());
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        if(!($favourite instanceof Favourite))
        {
            return response()->json([
                'success' => 'This location is no longer a favourite',
                'data' => [
                    'location' => $location->id
                ]
            ], 201);
        }

        return (new LocationFavouriteResource($favourite))
            ->additional([
                'success' => 'This location has been added to your favourites'
            ]);

    }
}
