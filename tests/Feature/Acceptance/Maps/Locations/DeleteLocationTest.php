<?php

namespace Tests\Feature\Acceptance\Maps\Locations;

use App\Location;
use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteLocationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var string
     */
    protected $route;
    /**
     * @var TestResponse
     */
    protected $response;

    protected function setUp()
    {
        parent::setUp();
        $location = create(Location::class);
        $this->route = route('location.delete', ['location' => $location]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function a_user_must_be_logged_in_to_delete_a_record()
    {
        $this->json('delete', $this->route)
            ->assertStatus(401);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function the_location_must_belong_to_the_user()
    {
        $this->response = $this->signIn()
            ->json('delete', $this->route)
            ->assertStatus(401);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     */
    public function the_must_be_removed_from_the_database()
    {
        $user = create(User::class);
        $location = create(Location::class, [
            'user_id' => $user->id
        ]);
        $route = route('location.delete', ['location' => $location]);
        $this->response = $this->signIn($user)
            ->json('delete', $route)
            ->assertStatus(200)
            ->assertJson([
                'success' =>  'Congratulations, you deleted a location!'
            ]);
    }
}
