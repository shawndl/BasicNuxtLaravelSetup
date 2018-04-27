<?php

namespace Tests\Feature\Acceptance\Maps\Locations;

use App\Image;
use App\LocationType;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLocationSuccessTest extends TestCase
{
    use RefreshDatabase;
    protected $post = [
        'name' => 'Blue Berry Bush',
        'description' => 'A description',
        'latitude' => '-20.385825381874263',
        'longitude' => '-20.385825381874263'
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->post['type'] = create(LocationType::class)->id;
        $this->post['image'] = UploadedFile::fake()->image('test.jpg');
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_must_be_added_to_the_database()
    {
        $this->signIn()
            ->json('post', route('location.store'), $this->post)
            ->assertStatus(201)
            ->assertJson([
                'success' => 'Congratulations, you just added a new location!'
            ]);

        $this->assertDatabaseHas('locations', [
            'name' => 'blue berry bush'
        ]);
    }
}
