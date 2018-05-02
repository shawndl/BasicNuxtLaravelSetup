<?php

namespace Tests\Feature\Acceptance\Maps\Locations\Feedback;

use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddFeedBackTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array
     */
    protected $post = [
        'review'=> 3,
        'comment' => 'this place is good'
    ];

    /**
     * @var string
     */
    protected $route;

    /**
     * @var Location
     */
    protected $location;

    protected function setUp()
    {
        parent::setUp();
        $this->location = create(Location::class);
        $this->route = route('location.feedback.store', ['location' => $this->location->id]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     * @group feedback
     */
    public function a_user_must_be_signed_in_to_add_feedback()
    {
        $this->json('post', $this->route, $this->post)
            ->assertStatus(401);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     * @group feedback
     */
    public function a_user_must_be_able_to_add_feedback_to_a_location()
    {
        $user = create(User::class);
        $this->signIn($user)
            ->json('post', $this->route, $this->post)
            ->assertStatus(201)
            ->assertJson([
                'success' => 'You added feedback to a location!',
                'data' => [
                    'review'=> 3,
                    'comment' => 'this place is good',
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->name
                    ]
                ]
            ]);
        $this->assertDatabaseHas('feedback', [
            'review'=> 3,
            'comment' => 'this place is good'
        ]);
    }
}
