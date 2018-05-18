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

class LocationController extends Controller
{
    use JsonResponseTrait;

    /**
     * @var ImageServiceInterface
     */
    protected $imageService;

    /**
     * LocationController constructor.
     * @param ImageServiceInterface $imageService
     */
    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }


    /**
     * @param Location $locations
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection | JsonResponse
     */
    public function index(Location $locations)
    {
        try {
            $locations = $locations->isPublic()->with('type.encyclopedia', 'user', 'image', 'feedback.user')->get();
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
     * @param Image $image
     * @return \Illuminate\Http\JsonResponse
     * @internal param Location $location
     */
    public function store(LocationRequest $request, Image $image)
    {
        $post = $request->all();
        try {
            $tempPath = $request->file('image')->path();
            $this->imageService
                ->set($tempPath)
                ->cropSquare()
                ->resize(200, 200)
                ->save();


            $path = $request->file('image')->store('public');
            $location = $image->create([
                'path' => $path
            ])->locations()
                ->create([
                    'user_id' => Auth::id(),
                    'location_type_id' => $post['type'],
                    'description' => $post['description'],
                    'latitude' => $post['latitude'],
                    'longitude' => $post['longitude'],
                    'is_private'=> $post['private']
                ]);
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return $this->successResponse('Congratulations, you just added a new location!', 201);
    }
}
