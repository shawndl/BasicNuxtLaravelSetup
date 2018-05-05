<?php

namespace Tests\Feature\Acceptance\Maps\Locations;

use App\LocationType;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLocationFailValidationTest extends TestCase
{
    use RefreshDatabase;
    protected $post = [
        'name' => 'Blue Berry Bush',
        'description' => 'A description',
        'latitude' => '-20.385825381874263',
        'longitude' => '-20.385825381874263',
        'image' => ''
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
    public function a_location_must_have_a_type()
    {
        $this->post['type'] = '';
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "type" => [
                    0 => "The type field is required."
                ]
            ]
        ]);
    }


    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_type_must_be_a_number()
    {
        $this->post['type'] = 'a string';
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "type" => [
                    0 => "The type must be a number."
                ]
            ]
        ]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_must_have_a_description()
    {
        $this->post['description'] = '';
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "description" => [
                    0 => "The description field is required."
                ]
            ]
        ]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_description_must_be_a_string()
    {
        $this->post['description'] = 82908552340983542089;
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "description" => [
                    0 => "The description must be a string."
                ]
            ]
        ]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_must_have_a_latitude()
    {
        $this->post['latitude'] = '';
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "latitude" => [
                    0 => "The latitude field is required."
                ]
            ]
        ]);
    }


    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_latitude_must_be_a_number()
    {
        $this->post['latitude'] = 'a string';
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "latitude" => [
                    0 => "The latitude must be a number."
                ]
            ]
        ]);
    }


    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_must_have_a_longitude()
    {
        $this->post['longitude'] = '';
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "longitude" => [
                    0 => "The longitude field is required."
                ]
            ]
        ]);
    }


    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_longitude_must_be_a_number()
    {
        $this->post['longitude'] = 'a string';
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "longitude" => [
                    0 => "The longitude must be a number."
                ]
            ]
        ]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_must_have_a_image()
    {
        $this->post['image'] = '';
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "image" => [
                    0 => "The image field is required."
                ]
            ]
        ]);
    }


    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_location_image_must_be_an_image_file()
    {
        $this->post['image'] = UploadedFile::fake()->create('badstuff.js');
        $this->sendRequest()->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "image" => [
                    0 => "The image must be an image."
                ]
            ]
        ]);
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function sendRequest()
    {
        return $this->signIn()
            ->json('post', route('location.store'), $this->post);
    }
}
