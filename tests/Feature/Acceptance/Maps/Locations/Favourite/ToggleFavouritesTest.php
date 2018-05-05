<?php

namespace Tests\Feature\Acceptance\Maps\Locations\Favourite;

use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToggleFavouritesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Location
     */
    protected $location;

    protected function setUp()
    {
        parent::setUp();
        $this->user = create(User::class);
        $this->location = create(Location::class);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_user_must_be_able_to_get_all_their_favourites()
    {
        $route = route('location.favourite.store');

        $this->signIn($this->user)
            ->json('post', $route, ['location' => $this->location->id])
            ->assertStatus(201)
            ->assertJson([
                'success' => 'This location has been added to your favourites',
                'data' => [
                    'location' => $this->location->id
                ]
            ]);

        $this->assertDatabaseHas('favourites', [
            'user_id' => $this->user->id,
            'favourite_id' => $this->location->id,
            'favourite_type' => 'App\Location'
        ]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function it_must_be_able_to_remove_a_location_from_the_favourite()
    {
        $this->location->addFavourite($this->user);
        $route = route('location.favourite.store');
        $this->signIn($this->user)
            ->json('post', $route, ['location' => $this->location->id])
            ->assertStatus(201)
            ->assertJson([
                'success' => 'This location is no longer a favourite',
                'data' => [
                    'location' => $this->location->id
                ]
            ]);


        $this->assertDatabaseMissing('favourites', [
            'user_id' => $this->user->id,
            'favourite_id' => $this->location->id,
            'favourite_type' => 'App\Location'
        ]);
    }
}
