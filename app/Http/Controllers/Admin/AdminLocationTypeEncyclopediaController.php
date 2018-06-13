<?php

namespace App\Http\Controllers\Admin;

use App\Encyclopedia;
use App\Http\Requests\Admin\RemoveEncyclopediaRequest;
use App\Http\Requests\Maps\AddEncyclopediaRequest;
use App\Http\Resources\Location\EncylopediaResource;
use App\Http\Resources\Location\LocationTypeResource;
use App\LocationType;
use App\Traits\Controllers\JsonResponseTrait;
use App\Http\Controllers\Controller;

class AdminLocationTypeEncyclopediaController extends Controller
{
    use JsonResponseTrait;

    /**
     * adds a link to the type
     *
     * @param LocationType $locationType
     * @param AddEncyclopediaRequest $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function add(LocationType $locationType, AddEncyclopediaRequest $request)
    {
        try {
            $link = $locationType->addLink($request->path, $request->name);
            $locationType = $locationType->load('encyclopedia', 'image');
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return (new LocationTypeResource($locationType))
            ->additional([
                'success' => 'You added a reference to a location type'
            ]);
    }

    /**
     * removes a link from a location type
     *
     * @param RemoveEncyclopediaRequest $request
     * @param Encyclopedia $encyclopedia
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(RemoveEncyclopediaRequest $request, Encyclopedia $encyclopedia)
    {

        try {
            $encyclopedia->delete();
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return response()->json([
           'success' => 'You removed an encyclopedia link'
        ], 201);
    }
}
