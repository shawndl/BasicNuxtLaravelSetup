<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\Account\ProfileStoreRequest;
use App\Traits\Controllers\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    use JsonResponseTrait;
    /**
     * updates the users Profile
     *
     * @param ProfileStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProfileStoreRequest $request)
    {
        try {
            $request->user()
                ->update($request->only('name', 'email'));
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return response()->json([
           'message' => 'Your Profile has been updated!'
        ]);
    }
}
