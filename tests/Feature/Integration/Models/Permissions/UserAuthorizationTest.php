<?php

namespace Tests\Feature\Integration\Models\Permissions;

use App\Permission;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $user = create(User::class);
        $user->roles()->attach(create(Role::class, ['name' => 'admin']));
    }

    /**
     * @group integration
     * @group model
     * @group permission
     * @test
     */
    public function a_user_can_have_a_role()
    {
        $this->assertCount(1, User::first()->roles);
    }

    /**
     * @group integration
     * @group model
     * @group permission
     * @test
     */
    public function a_user_must_be_able_to_check_if_it_has_a_specific_role()
    {
        $user = User::first();
        $this->assertTrue($user->hasRole('admin'));
        $this->assertFalse($user->hasRole('leader'));
    }


    /**
     * @group integration
     * @group model
     * @group permission
     * @test
     */
    public function a_user_must_be_able_to_check_if_it_has_a_any_role()
    {
        $user = User::first();
        $this->assertTrue($user->hasAnyRole('admin', 'leader'));
        $this->assertFalse($user->hasAnyRole('leader', 'staff'));
    }
}
