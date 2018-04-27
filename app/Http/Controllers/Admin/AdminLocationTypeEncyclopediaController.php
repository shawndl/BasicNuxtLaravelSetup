<?php

namespace App\Http\Controllers\Admin;

use App\Encyclopedia;
use App\Http\Requests\Admin\RemoveEncyclopediaRequest;
use App\Http\Requests\Maps\AddEncyclopediaRequest;
use App\Http\Resources\Location\EncylopediaResource;
use App\LocationType;
use App\Traits\Controllers\JsonResponseTrait;
use App\Http\Controllers\Controller;

class AdminLocationTypeEncyclopediaController extends Controller
{
    use JsonResponseTrait;
    public function add(LocationType $locationType, AddEncyclopediaRequest $request)
    {
        try {
            $link = $locationType->addLink($request->link, $request->name);
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return (new EncylopediaResource($link))
            ->additional([
                'success' => 'You added a reference to a location type'
            ]);
    }

    public function remove(RemoveEncyclopediaRequest $request, LocationType $type, Encyclopedia $encyclopedia)
    {

        try {
            $type = $type->find($request->type);
            $encyclopedia = $encyclopedia->find($request->link);
            if(!$type->hasLinkTo($encyclopedia))
            {
                abort(422);
            }
            $encyclopedia->delete();
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return response()->json([
           'success' => 'You removed an encyclopedia link'
        ], 201);
    }
}
