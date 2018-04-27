<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Maps\LocationTypeRequest;
use App\Http\Requests\Maps\LocationTypeUpdateRequest;
use App\Http\Resources\Location\LocationTypeResource;
use App\Image;
use App\LocationType;
use App\Traits\Controllers\JsonResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLocationTypeController extends Controller
{
    use JsonResponseTrait;

    /**
     * @var LocationType
     */
    protected $type;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var string
     */
    protected $path;

    /**
     * AdminLocationTypeController constructor.
     * @param LocationType $type
     * @param Image $image
     */
    public function __construct(LocationType $type, Image $image)
    {
        $this->type = $type;
        $this->image = $image;
    }


    /**
     * creates a new location type
     *
     * @param LocationTypeRequest $request
     * @return LocationTypeResource | JsonResponse
     */
    public function store(LocationTypeRequest $request)
    {
        try {
            $this->type = $this->type->create($this->getPost($request));
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return (new LocationTypeResource($this->type->load('image')))
                ->additional([
                'success' => 'A new location type has been created'
            ]);
    }

    /**
     * updates a location type
     *
     * @param LocationTypeUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse | LocationTypeResource
     */
    public function update(LocationTypeUpdateRequest $request, LocationType $locationType)
    {
        try {
            $locationType->update($this->getPost($request));
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return (new LocationTypeResource($locationType->load('image')))
            ->additional([
                'success' => 'A location type has been updated'
            ]);
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
            return $this->processingError($exception);
        }

        return $this->successResponse('The location type was deleted!');
    }

    /**
     * creates the post data
     *
     * @param Request $request
     * @return array
     */
    private function getPost(Request $request)
    {
        $post = $this->getCommonValues($request);
        if($this->createImage($request))
        {
            $post['image_id'] = $this->image->id;
        }
        return $post;
    }

    /**
     * creates an image
     * returns true if image was created or false if no image is created
     *
     * @param Request $request
     * @return bool
     */
    private function createImage(Request $request)
    {
        if(!is_null($request->image))
        {
            $this->path = $request->file('image')->store('public/icons');
            $this->image = $this->image->create([
                'path' => $this->path
            ]);
            return true;
        }
        return false;
    }

    /**
     * gets the common values
     *
     * @param Request $request
     * @return array
     */
    private function getCommonValues(Request $request)
    {
        return [
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'season_start' => strtotime($request->start),
            'season_finish' => strtotime($request->end),
        ];
    }
}
