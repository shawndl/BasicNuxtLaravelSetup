<?php

namespace Tests\Feature\Integration\Models\Traits;

use App\Image;
use App\Location;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasImageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var Location
     */
    protected $model;

    protected function setUp()
    {
        parent::setUp();
        $this->model = factory(Location::class)->create();
    }

    /**
     * @group integration
     * @group model
     * @group traits
     * @test
     */
    public function a_model_with_an_has_image_trait_must_have_an_image()
    {
        $image = Image::first()->id;
        $this->assertEquals($image, $this->model->image_id);
    }

    /**
     * @group integration
     * @group model
     * @group traits
     * @test
     */
    public function a_model_with_an_has_image_trait_must_return_the_path()
    {
        $image = Image::first()->path;
        $this->assertEquals($image, $this->model->path());
    }
}
