<?php

namespace Tests\Feature\Integration\Models\Traits;

use App\Encyclopedia;
use App\LocationType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasEncyclopediaTraitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var LocationType
     */
    protected $model;

    protected function setUp()
    {
        parent::setUp();
        $this->model = factory(LocationType::class)->create();
    }

    /**
     * @group integration
     * @group model
     * @group traits
     * @test
     */
    public function a_model_with_an_has_encyclopedia_trait_must_have_an_reference_in_the_db()
    {
        $this->model->encyclopedia()->create([
            'path' => 'random info'
        ]);
        $this->assertCount(1, $this->model->encyclopedia);
    }

    /**
     * @group integration
     * @group model
     * @group traits
     * @test
     */
    public function a_model_with_an_has_encyclopedia_trait_can_add_a_link()
    {
        $this->model->addLink('some_random_link');
        $link = Encyclopedia::first();
        $this->assertEquals('some_random_link', $link->path);
        $this->assertEquals($this->model->id, $link->encyclopedia_id);
    }

    /**
     * @group integration
     * @group model
     * @group traits
     * @test
     */
    public function a_model_with_an_has_encyclopedia_trait_can_check_if_relationship_exists()
    {
        $this->model->addLink('some_random_link');
        $link = Encyclopedia::first();
        $this->assertTrue($this->model->hasLinkTo($link));

        $link2 = create(Encyclopedia::class);
        $this->assertFalse($this->model->hasLinkTo($link2));
    }

}
