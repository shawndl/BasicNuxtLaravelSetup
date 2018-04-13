<?php

namespace Tests\Feature\Acceptance\Maps\Types;

use App\LocationType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateLocationTypesTest extends TestCase
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
    public function it_must_be_able_to_update_a_location_type()
    {
        $type = create(LocationType::class);

        $this->signInAdmin()
            ->json('put', route('admin.location.type.update', [$type->id]), $this->post)
            ->assertStatus(200)
            ->assertJson([
                'success' => 'A location type has been updated'
            ]);

        $this->assertDatabaseHas('location_types', [
            'name' => 'berry',
            'season_start' => '2018-04-03 03:48:00'
        ]);
    }
}
