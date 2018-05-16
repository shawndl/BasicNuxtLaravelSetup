<?php
/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 25/4/18
 * Time: 3:09 PM
 */

namespace App\Traits\Models;


use App\Image;

trait HasImageTrait
{
    /**
     * a location has an image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * gets the path to the image
     *
     * @return string
     */
    public function path()
    {
        return $this->image->path;
    }

    /**
     * gets the path to the storage file
     *
     * @return string
     */
    public function imageFile()
    {
        $file = substr($this->path(), strrpos($this->path(), '/') + 1);
        return storage_path() . '/app/public/' . $file;
    }

}