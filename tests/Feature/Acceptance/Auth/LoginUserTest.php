<?php

namespace Tests\Feature\Acceptance\Auth;

use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array
     */
    protected $post;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $user;

    /**
     * @group acceptance
     * @group Auth
     * @test
     */
    public function a_user_must_be_active_to_login()
    {
        $this->sendResponse(false)
            ->assertStatus(403)
            ->assertJson([
                'error' => 'Your account is not active'
            ]);
        $this->assertFalse(Auth::check());
    }

    /**
     * @group acceptance
     * @group Auth
     * @test
     */
    public function it_must_return_a_token_if_email_and_password_matches()
    {
        $this->sendResponse()->assertJsonStructure([
            'data' => ['id', 'name', 'email'], 'meta' => ['token']
        ]);
    }

    /**
     * @group acceptance
     * @group Auth
     * @test
     */
    public function if_the_credentials_do_not_match_an_error_will_be_returned()
    {
        $this->sendResponse(true, 'notsecret')
            ->assertJson([
            'errors' => ['email' => ['Sorry we couldn\'t sign you in with those details.']
            ]
        ]);
    }

    /**
     * sends login response
     * @param bool $active
     * @param string $password
     * @return TestResponse
     */
    private function sendResponse($active = true, $password = 'secret')
    {
        $this->user = create(User::class, [
            'is_active' => $active,
            'password' => bcrypt('secret')
        ])->toArray();
        $this->post['email'] = $this->user['email'];
        $this->post['password'] = $password;
        $this->url = route('login');
        return $this->json('post', $this->url, $this->post);
    }
}