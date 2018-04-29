<?php

namespace Tests\Feature\Integration\Models\Traits;

use App\Feedback;
use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasFeedbackTraitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var Location
     */
    protected $model;

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
            ->each(function(Location $location) {
                $location->review($this->user, 5, 'awesome place');
            });
        $this->model = Location::first();
    }

    /**
     * @group integration
     * @group model
     * @group maps
     * @test
     */
    public function feedback_must_have_a_location()
    {

        $this->assertEquals('awesome place', $this->model->feedback->first()->comment);
    }

    /**
     * @group integration
     * @group model
     * @group maps
     * @test
     */
    public function a_user_can_add_feedback()
    {
        $location2 = create(Location::class);
        $location2->review($this->user, '2', 'kind of boring');
        $feedback = Feedback::get();

        $this->assertCount(2, $feedback);
        $this->assertContains('kind of boring', $feedback->last()->comment);
    }

    /**
     * @group integration
     * @group model
     * @group maps
     * @test
     */
    public function feedback_must_have_a_user()
    {
        $this->assertEquals($this->user->id, $this->model->feedback->first()->user_id);
    }
}
