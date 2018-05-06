<?php

namespace Tests\Feature\Integration\Models\Maps;

use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavouriteModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group integration
     * @group model
     * @group maps
     * @test
     */
    public function a_favourite_must_have_a_user()
    {
        $user = create(User::class);
        $location = create(Location::class);
        $location->favourites()->create([
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('favourites', [
            'user_id' => $user->id,
            'favourite_id' => $location->id,
            'favourite_type' => 'App\Location'
        ]);
    }

    /**
     * @group integration
     * @group model
     * @group maps
     * @test
     */
    public function a_location_can_add_a_favourite()
    {
        $user = create(User::class);
        $location = create(Location::class);
        $location->addFavourite($user);

        $this->assertDatabaseHas('favourites', [
            'user_id' => $user->id,
            'favourite_id' => $location->id,
            'favourite_type' => 'App\Location'
        ]);
    }

    /**
     * @group integration
     * @group model
     * @group maps
     * @test
     */
    public function a_user_can_have_many_users()
    {
        $user = create(User::class);
        $location = create(Location::class);
        $location->addFavourite($user);
        $location2 = create(Location::class);
        $location2->addFavourite($user);
        $location3 = create(Location::class);
        $location3->addFavourite($user);

        $this->assertCount(3, $user->favourites);
    }

}
