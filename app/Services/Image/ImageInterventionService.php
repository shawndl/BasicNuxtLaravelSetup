<?php

namespace App\Services\Image;


use Intervention\Image\Facades\Image;

class ImageInterventionService implements ImageServiceInterface
{
    /**
     * @var \Intervention\Image\Image
     */
    protected $service;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $cropValues = [
        'height' => 0,
        'width' => 0,
        'x' => 0,
        'y' => 0
    ];

    /**
     * @var array
     */
    protected $currentDimensions = [
        'height' => 0,
        'weight' => 0
    ];


    /**
     * sets the current dimensions
     *
     * @param string $path
     * @return $this
     */
    public function set(string $path)
    {
        $this->service = Image::make($path);
        $this->path = $path;
        $this->setDimensions();
        return $this;
    }

    /**
     * it crops an image
     *
     * @param int $top
     * @param int $left
     * @param int $height
     * @param int $width
     * @return $this
     */
    public function crop(int $top, int $left, int $height, int $width)
    {
        // TODO: Implement crop() method.
    }

    /**
     * crops the image to a square
     *
     * @return $this
     */
    public function cropSquare()
    {
        if($this->isSquare()) return $this;

        $this->setCropValues();

        $this->service->crop((int)$this->cropValues['width'], (int)$this->cropValues['height'], floor($this->cropValues['x']), floor($this->cropValues['y']));

        return $this;
    }

    /**
     * resizes the images, the path can be null if it was set in
     *
     * @param int $height
     * @param int $width
     * @return string
     */
    public function resize(int $height, int $width)
    {
        $this->service->resize($width, $height);
        return $this;
    }

    /**
     * saves the image and gets path to new image
     *
     * @return string
     */
    public function save()
    {
        $this->service->save($this->path);
        return $this->service->basePath();
    }

    /**
     * set dimensions of the current image
     *
     * @return void
     */
    protected function setDimensions()
    {
        $sizes = getimagesize($this->path);
        $this->currentDimensions = [
            'width' => $sizes[0],
            'height' => $sizes[1]
        ];
    }

    /**
     * sets the cutWidth or cutHeight
     *
     * @return void
     */
    protected function setCropValues()
    {
        if($this->isVertical())
        {
            $this->setVertical();
            return;
        }
        $this->setHorizontal();
    }

    /**
     * is the height larger than the width
     *
     * @return bool
     */
    protected function isVertical()
    {
        return $this->currentDimensions['height'] > $this->currentDimensions['width'];
    }

    /**
     * is the image a square
     *
     * @return bool
     */
    protected function isSquare()
    {
        return $this->currentDimensions['height'] === $this->currentDimensions['width'];
    }

    /**
     * sets crop values for vertical
     *
     * @return void
     */
    protected function setVertical()
    {
        $difference = $this->currentDimensions['height'] - $this->currentDimensions['width'];
        $this->cropValues['height'] = $this->currentDimensions['height'] - $difference;
        $this->cropValues['width'] = $this->currentDimensions['width'];
        $this->cropValues['y'] =  $difference / 2;
    }

    /**
     * sets crop values for horizontal
     *
     * @return void
     */
    protected function setHorizontal()
    {
        $difference = $this->currentDimensions['width'] - $this->currentDimensions['height'];
        $this->cropValues['width'] = $this->currentDimensions['width'] - $difference;
        $this->cropValues['height'] = $this->currentDimensions['height'];
        $this->cropValues['x'] =  $difference / 2;
    }
}