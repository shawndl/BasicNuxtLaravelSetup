<?php

namespace Tests\Feature\Acceptance\Maps\Types;

use App\LocationType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowLocationTypesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function it_must_be_able_to_all_location_types()
    {
        $location = create(LocationType::class);
        $this->json('get', route('location.type.show', [$location->id]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name', 'description', 'start', 'end'
                ]
            ]);
    }
}
