<?php

namespace Tests\Feature\Acceptance\Maps\Locations;

use App\Image;
use App\Location;
use App\LocationType;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
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
                'success' => 'Congratulations, you just added a new location!',
                'data' => [
                    'id'=> 1,
                    'description'=> 'A description',
                    'latitude'=> '-20.385825381874263',
                    'longitude'=> '-20.385825381874263'
                ]
            ])->assertJsonStructure([ 'data' => [
                'image'=> ['path'],
                'user'=> ['id', 'username'],
                'type'=> ['id', 'name', 'description', 'start', 'start_format', 'end', 'end_format', 'icon', 'image'],
                'feedback'=> []
            ]]);

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

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function if_a_new_location_is_created_then_query_cache_for_location_is_deleted()
    {
        $this->signIn()->json('get', route('location.index'));
        $this->assertTrue(Cache::has('query.locations.all'));

        $this->response = $this->signIn()
            ->json('post', route('location.store'), $this->post);
        $this->assertFalse(Cache::has('query.locations.all'));

    }
}
