<?php

namespace Tests\Feature\Acceptance\Maps\Types;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLocationTypesTest extends TestCase
{
    use RefreshDatabase;
    protected $post = [
        'name' => 'berry',
        'description' => 'A description',
        'start' => 'Tue Apr 03 2018 13:48:00 GMT+1000 (AEST)',
        'end' => 'Wed Apr 11 2018 13:48:00 GMT+1000 (AEST)'
    ];

    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_be_able_to_create_a_location_type()
    {
        $this->signInAdmin()
            ->json('post', route('admin.location.type.store'), $this->post)
            ->assertStatus(201)
            ->assertJson([
                'success' => 'A new location type has been created'
            ]);

        $this->assertDatabaseHas('location_types', [
            'name' => 'berry',
            'season_start' => '2018-04-03 03:48:00'
        ]);
    }
}
