<?php

namespace Tests\Feature\Acceptance\Maps\Types;

use App\LocationType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteLocationTypesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_be_able_to_delete_a_location_type()
    {
        $type = create(LocationType::class);

        $this->signInAdmin()
            ->json('delete', route('admin.location.type.delete', [$type->id]))
            ->assertStatus(200)
            ->assertJson([
                'success' => 'The location type was deleted!'
            ]);

        $this->assertDatabaseMissing('location_types', [
            'name' => $type->name,
        ]);
    }
}
