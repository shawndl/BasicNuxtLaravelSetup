<?php

namespace Tests\Feature\Acceptance\Auth;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogOutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @group acceptance
     * @group Auth
     * @test
     */
    public function it_must_be_able_to_log_the_user_out()
    {
        $this->signIn();
        $this->assertTrue(Auth::check());

        $this->json('post', route('logout'))
            ->assertStatus(200)
            ->assertJson(['message' => 'You are logged out!']);
        $this->assertFalse(Auth::check());
    }
}
