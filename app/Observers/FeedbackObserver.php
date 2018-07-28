<?php
/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 28/7/18
 * Time: 5:50 PM
 */

namespace App\Observers;


use App\Events\Models\Cache\LocationsChanged;
use App\Feedback;

class FeedbackObserver
{
    /**
     * Listen for when a location is created and deletes the query cache.
     *
     * @param Feedback $feedback
     * @return void
     */
    public function created(Feedback $feedback)
    {
        $location = $feedback->location;
        event(new LocationsChanged($location));
    }

    /**
     * Listen for when a location is deleted and deletes the query cache.
     *
     * @param Feedback $feedback
     * @return void
     */
    public function updated(Feedback $feedback)
    {
        $location = $feedback->location;
        event(new LocationsChanged($location));
    }

    /**
     * Listen for when a location is deleted and deletes the query cache.
     *
     * @param Feedback $feedback
     * @return void
     */
    public function deleted(Feedback $feedback)
    {
        $location = $feedback->location;
        event(new LocationsChanged($location));
    }
}