<?php
/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 9/5/18
 * Time: 7:03 PM
 */

namespace App\Services\Image;


interface ImageServiceInterface
{
    /**
     * sets the current dimensions
     *
     * @param string $path
     * @return $this
     */
    public function set(string $path);

    /**
     * it crops an image
     *
     * @param int $top
     * @param int $left
     * @param int $height
     * @param int $width
     * @return $this
     */
    public function crop(int $top, int $left, int $height, int $width);

    /**
     * crops the image to a square
     *
     * @return $this
     */
    public function cropSquare();


    /**
     * resizes the images, the path can be null if it was set in
     *
     * @param int $height
     * @param int $width
     * @return $this
     */
    public function resize(int $height, int $width);

    /**
     * saves the image and returns the current path
     *
     * @return string
     */
    public function save();
}