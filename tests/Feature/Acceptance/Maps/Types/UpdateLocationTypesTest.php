<?php

namespace Tests\Feature\Acceptance\Maps\Types;

use App\Image;
use App\LocationType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateLocationTypesTest extends TestCase
{
    use RefreshDatabase;

    protected $post = [
        'name' => 'berry',
        'description' => 'A description',
        'icon' => 'link_to_an_icon',
        'start' => 'Tue Apr 03 2018 13:48:00 GMT+1000 (AEST)',
        'end' => 'Wed Apr 11 2018 13:48:00 GMT+1000 (AEST)'
    ];

    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_be_able_to_update_a_location_type()
    {
        $type = create(LocationType::class);

        $this->signInAdmin()
            ->json('post', route('admin.location.type.update', [$type->id]), $this->post)
            ->assertStatus(200)
            ->assertJson([
                'success' => 'A location type has been updated',
                'data' => [
                    'id' => $type->id,
                    'name' => 'Berry',
                    'description'=> 'A description',
                    'icon' => 'link_to_an_icon',
                    'start' => [
                        'date' => '2018-04-03 03:48:00.000000',
                        'timezone_type' => 3,
                        'timezone' => 'UTC'
                    ],
                    'start_format' => 'April',
                    'end' => [
                        'date' => '2018-04-11 03:48:00.000000',
                        'timezone_type' => 3,
                        'timezone' => 'UTC'
                    ],
                ]
            ]);

        $this->assertDatabaseHas('location_types', [
            'name' => 'berry',
            'season_start' => '2018-04-03 03:48:00'
        ]);
    }


    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_be_able_to_update_a_location_type_with_an_image()
    {
        $type = create(LocationType::class);
        $this->post['image'] = UploadedFile::fake()->image('test.png');
        $this->signInAdmin()
            ->json('post', route('admin.location.type.update', [$type->id]), $this->post)
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => 'A location type has been updated'
            ]);
        $this->assertDatabaseHas('location_types', [
            'name' => 'berry',
            'image_id' => 2
        ]);
    }

    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_delete_the_cache_when_a_type_is_updated()
    {
        $this->post['image'] = UploadedFile::fake()->image('test.png');
        $type = create(LocationType::class);
        $this->json('get', route('location.type.index'))->json();

        $this->assertTrue(Cache::has('query.types.all'));

        $this->signInAdmin()
            ->json('post', route('admin.location.type.update', [$type]), $this->post);

        $this->assertFalse(Cache::has('query.types.all'));

    }
}
