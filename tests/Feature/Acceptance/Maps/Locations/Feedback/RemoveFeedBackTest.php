<?php

namespace Tests\Feature\Acceptance\Maps\Locations\Feedback;

use App\Feedback;
use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemoveFeedBackTest extends TestCase
{
    use RefreshDatabase;

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
        $this->route = route('location.feedback.delete',
            ['feedback' => $this->feedback->id]);
    }

    /**
     * @test
     * @group acceptance
     * @group maps
     * @group feedback
     */
    public function a_user_must_be_signed_in_to_update_feedback()
    {
        $this->json('delete', $this->route)
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
            ->json('delete', $this->route)
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
            ->json('delete', $this->route)
            ->assertStatus(200)
            ->assertJson([
                'success' => 'You deleted feedback to a location!'
            ]);

        $this->assertDatabaseMissing('feedback', [
            'review'=> 1,
            'comment' => 'not good'
        ]);
    }
}
