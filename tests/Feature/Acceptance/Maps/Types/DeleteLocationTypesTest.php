<?php

namespace Tests\Feature\Acceptance\Maps\Types;

use App\LocationType;
use Illuminate\Support\Facades\Cache;
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

    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_delete_the_cache_when_a_type_is_deleted()
    {
        $type = create(LocationType::class);
        $this->json('get', route('location.type.index'))->json();

        $this->assertTrue(Cache::has('query.types.all'));

        $this->signInAdmin()
            ->json('delete', route('admin.location.type.delete', [$type->id]));
        $this->assertFalse(Cache::has('query.types.all'));

    }
}
