<?php

namespace Tests\Feature\Acceptance\Maps\Types;

use App\Encyclopedia;
use App\LocationType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTypeEncylopediaTest extends TestCase
{
    use RefreshDatabase;

    protected $post = [
        'name' => 'wikipedia',
        'link' => 'https://en.wikipedia.org/wiki/Main_Page'
    ];

    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function an_admin_can_add_an_encyclopedia_to_a_location_type()
    {
        $type = create(LocationType::class);

        $this->signInAdmin()
            ->json('post', route('admin.location.type.encyclopedia.add', [$type->id]), $this->post)
            ->assertStatus(201)
            ->assertJson([
                'success' => 'You added a reference to a location type',
                'data' => [
                    'path' => 'https://en.wikipedia.org/wiki/Main_Page'
                ]
            ]);

        $this->assertDatabaseHas('encyclopedias', [
            'path' => 'https://en.wikipedia.org/wiki/Main_Page'
        ]);
    }

    /**
     * @group acceptance
     * @group maps
     * @test
     */
    public function an_admin_can_remove_an_encyclopedia_to_a_location_type()
    {
        $type = create(LocationType::class);
        $type->addLink('https://en.wikipedia.org/wiki/Main_Page', 'wiki');
        $encyclopedia = Encyclopedia::first();
        $route =  route('admin.location.type.encyclopedia.remove', ['encyclopedia' => $encyclopedia->id]);

        $this->post['type'] = $type->id;
        $this->post['link'] = $encyclopedia->id;

        $this->signInAdmin()
            ->json('delete', $route)
            ->assertStatus(201)
            ->assertJson([
                'success' => 'You removed an encyclopedia link'
            ]);

        $this->assertDatabaseMissing('encyclopedias', [
            'path' => 'https://en.wikipedia.org/wiki/Main_Page'
        ]);
    }
}
