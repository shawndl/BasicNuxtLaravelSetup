<?php
/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 9/4/18
 * Time: 1:45 PM
 */

namespace App\Traits\Controllers;


use Illuminate\Support\Facades\App;

trait JsonResponseTrait
{
    /**
     * returns an error message
     *
     * @param $error
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function hasJsonError($error, $code)
    {
        return response()->json([
            'error' => $error
        ], $code);
    }

    /**
     * returns a standard processing error
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function processingError(\Exception $exception = null)
    {
        if(App::environment(['local', 'staging']) && !is_null($exception))
        {
            return response()->json([
                'error' => $exception->getMessage() . 'in ' . $exception->getFile() . ' on line ' .$exception->getLine()
            ], 500);
        }
        return $this->hasJsonError('Sorry an error occurred, Please try again',
            422);
    }

    /**
     * returns a standard message for json
     *
     * @param $message
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function messageResponse($message, $status = 200)
    {
        return response()->json([
            'message' => $message
        ], $status);
    }

    /**
     * returns a success message
     *
     * @param $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($message, $status = 200)
    {
        return response()->json([
            'success' => $message
        ], $status);
    }
}