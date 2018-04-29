<?php

namespace Tests\Feature\Acceptance\Maps\Locations\Feedback;

use App\Feedback;
use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditFeedBackTest extends TestCase
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
     * @var Feedback
     */
    protected $feedback;

    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = create(User::class);
        factory(Location::class)
            ->create()
            ->each(function($location) {
                $location->review($this->user, 1, 'not good');
            });
        $this->feedback = Feedback::first();
        $this->route = route('location.feedback.update', ['feedback' => $this->feedback->id]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     * @group feedback
     */
    public function a_user_must_be_signed_in_to_update_feedback()
    {
        $this->json('put', $this->route, $this->post)
            ->assertStatus(401);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     * @group feedback
     */
    public function a_user_must_own_the_feedback_to_edit_it()
    {
        $this->signIn()
            ->json('put', $this->route, $this->post)
            ->assertStatus(401);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     * @group feedback
     */
    public function a_user_must_be_able_to_update_feedback_to_a_location()
    {
        $this->signIn($this->user)
            ->json('put', $this->route, $this->post)
            ->assertStatus(200)
            ->assertJson([
                'success' => 'You updated feedback to a location!',
                'data' => [
                    'review'=> 3,
                    'comment' => 'this place is good'
                ]
            ]);

        $this->assertDatabaseHas('feedback', [
            'review'=> 3,
            'comment' => 'this place is good'
        ]);

        $this->assertDatabaseMissing('feedback', [
            'review'=> 1,
            'comment' => 'not good'
        ]);
    }
}
