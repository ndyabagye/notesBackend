<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tags;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_all_tags_list(): void
    {
        $allTags = Tags::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.all-tags.index'));

        $response->assertOk()->assertSee($allTags[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_tags(): void
    {
        $data = Tags::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.all-tags.store'), $data);

        $this->assertDatabaseHas('tags', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.all-tags.update', $tags), $data);

        $data['id'] = $tags->id;

        $this->assertDatabaseHas('tags', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_tags(): void
    {
        $tags = Tags::factory()->create();

        $response = $this->deleteJson(route('api.all-tags.destroy', $tags));

        $this->assertModelMissing($tags);

        $response->assertNoContent();
    }
}
