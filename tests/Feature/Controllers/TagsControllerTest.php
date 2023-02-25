<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Tags;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_all_tags(): void
    {
        $allTags = Tags::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('all-tags.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.all_tags.index')
            ->assertViewHas('allTags');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_tags(): void
    {
        $response = $this->get(route('all-tags.create'));

        $response->assertOk()->assertViewIs('app.all_tags.create');
    }

    /**
     * @test
     */
    public function it_stores_the_tags(): void
    {
        $data = Tags::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('all-tags.store'), $data);

        $this->assertDatabaseHas('tags', $data);

        $tags = Tags::latest('id')->first();

        $response->assertRedirect(route('all-tags.edit', $tags));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_tags(): void
    {
        $tags = Tags::factory()->create();

        $response = $this->get(route('all-tags.show', $tags));

        $response
            ->assertOk()
            ->assertViewIs('app.all_tags.show')
            ->assertViewHas('tags');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_tags(): void
    {
        $tags = Tags::factory()->create();

        $response = $this->get(route('all-tags.edit', $tags));

        $response
            ->assertOk()
            ->assertViewIs('app.all_tags.edit')
            ->assertViewHas('tags');
    }

    /**
     * @test
     */
    public function it_updates_the_tags(): void
    {
        $tags = Tags::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
        ];

        $response = $this->put(route('all-tags.update', $tags), $data);

        $data['id'] = $tags->id;

        $this->assertDatabaseHas('tags', $data);

        $response->assertRedirect(route('all-tags.edit', $tags));
    }

    /**
     * @test
     */
    public function it_deletes_the_tags(): void
    {
        $tags = Tags::factory()->create();

        $response = $this->delete(route('all-tags.destroy', $tags));

        $response->assertRedirect(route('all-tags.index'));

        $this->assertModelMissing($tags);
    }
}
