<?php

namespace Tests\Feature\Acceptance\Maps\Types;

use App\Image;
use App\LocationType;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLocationTypesTest extends TestCase
{
    use RefreshDatabase;

    protected $post = [
        'name' => 'berry',
        'description' => 'A description',
        'icon' => 'http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-8/128/Link-icon.png',
        'start' => 'Tue Apr 03 2018 13:48:00 GMT+1000 (AEST)',
        'end' => 'Wed Apr 11 2018 13:48:00 GMT+1000 (AEST)'
    ];

    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_be_able_to_create_a_location_type()
    {
        $this->post['image'] = UploadedFile::fake()->image('test.png');
        $this->assertCount(0, Image::all());

        $this->signInAdmin()
            ->json('post', route('admin.location.type.store'), $this->post)
            ->assertStatus(201)
            ->assertJson([
                'success' => 'A new location type has been created',
                'data' => [
                    'id' => 1,
                    'name' => 'Berry',
                    'description'=> 'A description',
                    'icon' => 'http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-8/128/Link-icon.png',
                    'start' => [
                        'date' => '2018-04-03 03:48:00.000000',
                        'timezone_type' => 3,
                        'timezone' => 'UTC'
                    ],
                    'start_format' => '3rd Apr',
                    'end' => [
                        'date' => '2018-04-11 03:48:00.000000',
                        'timezone_type' => 3,
                        'timezone' => 'UTC'
                    ],
                ]
            ]);
        $image = Image::first()->id;
        $this->assertNotNull($image);

        $this->assertDatabaseHas('location_types', [
            'name' => 'berry',
            'image_id' => $image,
            'icon' => 'http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-8/128/Link-icon.png',
            'season_start' => '2018-04-03 03:48:00'
        ]);
    }
}
