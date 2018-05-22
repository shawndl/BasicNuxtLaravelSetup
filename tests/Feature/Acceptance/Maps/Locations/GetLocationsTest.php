<?php

namespace Tests\Feature\Acceptance\Maps\Locations;

use App\Location;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetLocationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var TestResponse
     */
    protected $response;

    /**
     * @var Collection
     */
    protected $locations;

    /**
     * @var Location
     */
    protected $vip;

    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->locations = factory(Location::class, 2)
            ->create(['is_private' =>  false]);
        $this->user = create(User::class);
        $this->vip = create(Location::class, [
           'is_private' => true,
            'user_id' => $this->user->id
        ]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function it_must_return_locations_and_VIP_if_user_is_logged_in()
    {
        $this->signIn($this->user)
            ->json('get', route('location.index'))
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data' => [
                ['id', 'description', 'latitude', 'longitude',
                    'image' => ['path'],
                    'user' => ['id', 'username'],
                    'type' => ['id', 'name', 'start', 'start_format', 'end', 'end_format', 'icon'],
                    'feedback'
                ]
            ]]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function if_the_location_is_private_and_does_not_belong_to_the_user_then_it_must_not_be_returned()
    {
        $this->signIn()
            ->json('get', route('location.index'))
            ->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(['data' => [
                ['id', 'description', 'latitude', 'longitude',
                    'image' => ['path'],
                    'user' => ['id', 'username'],
                    'type' => ['id', 'name', 'start', 'start_format', 'end', 'end_format', 'icon'],
                    'feedback'
                ]
            ]]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function it_must_not_return_private_locations_if_the_user_is_not_logged_in()
    {
        $this->json('get', route('location.index'))
            ->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(['data' => [
                ['id', 'description', 'latitude', 'longitude',
                    'image' => ['path'],
                    'user' => ['id', 'username'],
                    'type' => ['id', 'name', 'start', 'start_format', 'end', 'end_format', 'icon'],
                    'feedback'
                ]
            ]]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function when_locations_are_retrieved_a_cache_is_created()
    {
        $this->signIn()->json('get', route('location.index'));
        $this->assertTrue(Cache::has('query.locations.all'));
    }
}
