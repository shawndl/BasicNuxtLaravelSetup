<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Maps\LocationTypeRequest;
use App\LocationType;
use App\Traits\Controllers\JsonResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLocationTypeController extends Controller
{
    use JsonResponseTrait;

    /**
     * creates a new location type
     *
     * @param LocationTypeRequest $request
     * @param LocationType $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LocationTypeRequest $request, LocationType $type)
    {
        try {
            $type->create([
                'name' => $request->name,
                'description' => $request->description,
                'season_start' => strtotime($request->start),
                'season_finish' => strtotime($request->end)
            ]);
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return $this->successResponse('A new location type has been created', 201);
    }

    /**
     * updates a location type
     *
     * @param LocationTypeRequest $request
     * @param LocationType $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LocationTypeRequest $request, LocationType $type)
    {
        try {
            $type->update([
                'name' => $request->name,
                'description' => $request->description,
                'season_start' => strtotime($request->start),
                'season_finish' => strtotime($request->end)
            ]);
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return $this->successResponse('A location type has been updated');
    }

    /**
     * deletes a location type
     *
     * @param LocationType $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LocationType $type)
    {
        try {
            $type->delete();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return $this->processingError($exception);
        }

        return $this->successResponse('The location type was deleted!');
    }
}
