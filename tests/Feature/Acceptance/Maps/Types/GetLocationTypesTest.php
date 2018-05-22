<?php

namespace Tests\Feature\Acceptance\Maps\Types;

use App\LocationType;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetLocationTypesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_be_able_to_all_location_types()
    {
        create(LocationType::class, [], 5);
        $this->json('get', route('location.type.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['name', 'description', 'start', 'end', 'id']
                ]
            ]);
    }

    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_create_a_cache_for_types()
    {
        create(LocationType::class);
        $this->json('get', route('location.type.index'));

        $this->assertTrue(Cache::has('query.types.all'));
    }
}
