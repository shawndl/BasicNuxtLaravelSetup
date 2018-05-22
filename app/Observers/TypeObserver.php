<?php
/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 22/5/18
 * Time: 7:38 PM
 */

namespace App\Observers;


use App\Events\Models\Cache\TypeChanged;

class TypeObserver
{
    /**
     * Listen for when a location is created and deletes the query cache.
     *
     * @return void
     */
    public function created()
    {
        event(new TypeChanged());
    }

    /**
     * Listen for when a location is deleted and deletes the query cache.
     *
     * @return void
     */
    public function updated()
    {
        event(new TypeChanged());
    }

    /**
     * Listen for when a location is deleted and deletes the query cache.
     *
     * @return void
     */
    public function deleted()
    {
        event(new TypeChanged());
    }
}