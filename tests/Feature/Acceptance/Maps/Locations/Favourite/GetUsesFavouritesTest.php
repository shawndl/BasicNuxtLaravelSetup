<?php

namespace Tests\Feature\Acceptance\Maps\Locations\Favourite;

use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetUsesFavouritesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $locations = [];

    protected function setUp()
    {
        parent::setUp();
        $this->user = create(User::class);
        $location = create(Location::class);
        $location->addFavourite($this->user);
        $location2 = create(Location::class);
        $location2->addFavourite($this->user);
        $location3 = create(Location::class);
        $location3->addFavourite($this->user);
        $this->locations = [
            $location->id, $location2->id, $location3->id
        ];
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_user_must_be_able_to_get_all_their_favourites()
    {
        $route = route('location.favourite.index');

        $this->signIn($this->user)
            ->json('get', $route)
            ->assertStatus(200)
            ->assertJson(['data' => [
                ['location' => $this->locations[0]],
                ['location' => $this->locations[1]],
                ['location' => $this->locations[2]]
            ]]);
    }
}
