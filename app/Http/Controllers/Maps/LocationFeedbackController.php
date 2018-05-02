<?php

namespace App\Http\Controllers\Maps;

use App\Feedback;
use App\Http\Resources\Location\LocationFeedBackResource;
use App\Location;
use App\Traits\Controllers\JsonResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LocationFeedbackController extends Controller
{
    use JsonResponseTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param Location $location
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse | LocationFeedBackResource
     */
    public function store(Location $location, Request $request)
    {
        try {
            $feedback = $location->review(auth()->user(), $request->review, $request->comment);
            $feedback->load('user');
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }


        return (new LocationFeedBackResource($feedback))
            ->additional([
                'success' => 'You added feedback to a location!'
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Feedback $feedback
     * @return \Illuminate\Http\JsonResponse | LocationFeedBackResource
     */
    public function update(Request $request, Feedback $feedback)
    {
        try {
            $feedback->update([
                'review' => $request->review,
                'comment' => $request->comment
            ]);
            $feedback->load('user');
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return (new LocationFeedBackResource($feedback))
            ->additional([
                'success' => 'You updated feedback to a location!'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Feedback $feedback
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Feedback $feedback)
    {
        try {
            $feedback->delete();
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return response()->json([
            'success' => 'You deleted feedback to a location!'
        ], 200);
    }
}
