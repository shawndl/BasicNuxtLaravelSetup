<?php

namespace Tests\Feature\Integration\Models\Maps;

use App\Feedback;
use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedbackModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var Feedback
     */
    protected $feedback;

    protected function setUp()
    {
        parent::setUp();
        $this->feedback = factory(Feedback::class)->create();
    }

    /**
     * @group integration
     * @group model
     * @group maps
     * @test
     */
    public function feedback_must_have_a_location()
    {
        $location = Location::first();
        $this->assertEquals($location->id, $this->feedback->location->id);
    }

    /**
     * @group integration
     * @group model
     * @group maps
     * @test
     */
    public function feedback_must_have_a_user()
    {
        $user = User::first();
        $this->assertEquals($user->id, $this->feedback->user->id);
    }
}
