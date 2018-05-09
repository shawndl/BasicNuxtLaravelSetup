<?php

namespace Tests\Feature\Integration\Services;

use App\Services\Image\ImageInterventionService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageCropperInterventionServiceTest extends TestCase
{
    /**
     * @group integration
     * @group images
     * @group service
     * @test
     */
    public function it_must_be_able_to_crop_an_image_to_a_square_if_the_height_is_bigger()
    {
        $image = UploadedFile::fake()->image('test.jpg', 800, 1200);
        $service = new ImageInterventionService();
        $path = $service->set($image->path())
            ->cropSquare()
            ->save();

        $sizes = getimagesize($path);
        $this->assertEquals(800, $sizes[0]);
        $this->assertEquals(800, $sizes[1]);

    }

    /**
     * @group integration
     * @group images
     * @group service
     * @test
     */
    public function it_must_be_able_to_crop_an_image_to_a_square_if_the_widht_is_bigger()
    {
        $image = UploadedFile::fake()->image('test.jpg', 120, 80);
        $service = new ImageInterventionService();
        $path = $service->set($image->path())
            ->cropSquare()
            ->save();

        $sizes = getimagesize($path);
        $this->assertEquals(80, $sizes[0]);
        $this->assertEquals(80, $sizes[1]);

    }

    /**
     * @group integration
     * @group images
     * @group service
     * @test
     */
    public function it_must_be_able_to_resize_the_image()
    {
        $image = UploadedFile::fake()->image('test.jpg', 800, 800);
        $service = new ImageInterventionService();
        $path = $service->set($image->path())
            ->resize(200, 200)
            ->save();

        $sizes = getimagesize($path);
        $this->assertEquals(200, $sizes[0]);
        $this->assertEquals(200, $sizes[1]);
    }

    /**
     * @group integration
     * @group images
     * @group service
     * @test
     */
    public function it_must_be_able_to_crop_and_resize_an_image()
    {
        $image = UploadedFile::fake()->image('test.jpg', 800, 1200);
        $service = new ImageInterventionService();
        $path = $service->set($image->path())
            ->cropSquare()
            ->resize(200, 200)
            ->save();

        $sizes = getimagesize($path);
        $this->assertEquals(200, $sizes[0]);
        $this->assertEquals(200, $sizes[1]);
    }
}
