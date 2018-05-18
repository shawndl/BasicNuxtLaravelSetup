<?php

namespace Tests\Feature\Acceptance\Maps\Locations;

use App\Image;
use App\Location;
use App\LocationType;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLocationSuccessTest extends TestCase
{
    use RefreshDatabase;
    protected $post = [
        'description' => 'A description',
        'latitude' => '-20.385825381874263',
        'longitude' => '-20.385825381874263',
        'private' => false
    ];

    /**
     * @var TestResponse
     */
    protected $response;

    protected function setUp()
    {
        parent::setUp();
        $this->post['type'] = create(LocationType::class)->id;
        $this->post['image'] = UploadedFile::fake()->image('test.jpg', 800, 1200);

        $this->response = $this->signIn()
            ->json('post', route('location.store'), $this->post);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_must_be_added_to_the_database()
    {
        $this->response
            ->assertStatus(201)
            ->assertJson([
                'success' => 'Congratulations, you just added a new location!'
            ]);

        $this->assertDatabaseHas('locations', [
            'latitude' => '-20.385825381874263'
        ]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function the_image_must_be_cropped_and_resized()
    {
        $location = Location::with('image')->first();
        $size = getimagesize($location->imageFile());
        $this->assertEquals(200, $size[0]);
        $this->assertEquals(200, $size[1]);
    }
}
