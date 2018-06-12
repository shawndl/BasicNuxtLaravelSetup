<?php

namespace App\Http\Controllers\Maps;

use App\Http\Requests\Maps\LocationRequest;
use App\Http\Resources\Location\LocationResource;
use App\Image;
use App\Location;
use App\Services\Image\ImageServiceInterface;
use App\Traits\Controllers\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    use JsonResponseTrait;

    /**
     * @var ImageServiceInterface
     */
    protected $imageService;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @var Image
     */
    protected $image;

    /**
     * LocationController constructor.
     * @param ImageServiceInterface $imageService
     * @param Location $location
     * @param Image $image
     */
    public function __construct(ImageServiceInterface $imageService, Location $location, Image $image)
    {
        $this->imageService = $imageService;
        $this->location = $location;
        $this->image = $image;
    }

    /**
     * @param Location $locations
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection | JsonResponse
     */
    public function index(Location $locations)
    {
        try {
            $locations= Cache::remember('query.locations.all', 1440, function () use ($locations){
                return $locations
                    ->isPublic()
                    ->has('type')
                    ->with('type.encyclopedia', 'type.image', 'user', 'image', 'feedback.user')
                    ->get();
            });
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return LocationResource::collection($locations);
    }

    /**
     * gets information about a single resource
     *
     * @param Location $location
     * @return LocationResource
     */
    public function show(Location $location)
    {
        return new LocationResource($location);
    }

    /**
     * creates a new location
     *
     * @param LocationRequest $request
     * @return LocationResource|JsonResponse
     */
    public function store(LocationRequest $request)
    {
        try {
            $this->cropImage($request);
            $image = $this->image->add($request);
            $location = $this->location->add($request, $image);
            $location->load('type.encyclopedia', 'type.image','user', 'image', 'feedback.user');
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return (new LocationResource($location))
            ->additional([
                'success' => 'Congratulations, you just added a new location!'
            ]);
    }

    /**
     * updates a location
     *
     * @param LocationRequest $request
     * @param Location $location
     * @return LocationResource|JsonResponse
     */
    public function update(LocationRequest $request, Location $location)
    {
        try {
            $this->cropImage($request);
            $image = $this->image->add($request);
            $location->edit($request, $image);

        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return (new LocationResource($location))
            ->additional([
                'success' => 'Congratulations, you just updated a location!'
            ]);
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
           'success' =>  'Congratulations, you deleted a location!'
        ]);
    }

    /**
     * crop the image to a square
     *
     * @param Request $request
     * @return void
     */
    private function cropImage(Request $request)
    {
        if($request->has('image'))
        {
            $tempPath = $request->file('image')->path();
            $this->imageService
                ->set($tempPath)
                ->cropSquare()
                ->resize(200, 200)
                ->save();
        }
    }
}
