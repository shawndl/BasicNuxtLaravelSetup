<?php

namespace Tests\Feature\Integration\Models\Maps;

use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group integration
     * @group model
     * @group auth
     * @test
     */
    public function a_location_must_have_a_user()
    {
        $location = create(Location::class);
        $this->assertNotNull($location->user->id);
    }

    /**
     * @group integration
     * @group model
     * @group auth
     * @test
     */
    public function a_location_can_have_an_image()
    {
        $location = create(Location::class);
        $this->assertNotNull($location->image->id);
    }

    /**
     * @group integration
     * @group model
     * @group auth
     * @test
     */
    public function a_location_can_have_a_null_image()
    {
        $location = factory(Location::class)->states('no-image')->create();
        $this->assertNull($location->image_id);
    }

    /**
     * @group integration
     * @group model
     * @group auth
     * @test
     */
    public function a_location_can_have_feedback()
    {
        $user = create(User::class);
        $location = create(Location::class);
        $location->review($user, 5, 'I love this place!');

        $this->assertEquals('I love this place!', $location->feedback->first()->comment);
    }

    /**
     * @group integration
     * @group model
     * @group auth
     * @test
     */
    public function a_location_can_have_lots_of_feedback()
    {
        $user = create(User::class);
        $user2 = create(User::class);
        $location = create(Location::class);
        $location->review($user, 5, 'I love this place!');
        $location->review($user2, 1, 'Its Ok!');

        $this->assertEquals(2, $location->feedback->count());
    }
}